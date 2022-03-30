<template>
  <div class="animated fadeIn">
    <b-card>
      <div slot="header">
        <b-row>
          <b-col cols="6">
            <span v-if="isUpdateForm">Rediģēt ražas datus</span>
            <span v-else>Izveidot datus par ražu</span>
          </b-col>
        </b-row>
      </div>
      <div v-if="spinners.contentIsLoading" class="text-center">
        <b-spinner type="grow" variant="primary"/>
      </div>
      <div v-else>
        <b-form-group :invalid-feedback="decimalErr(entity.quantity, 'Daudzums tonnās(t)')">
          <label>Kopējais novāktais daudzums tonnās(t)</label>
          <b-form-input type="text" placeholder="Daudzums tonnās(t)"
            v-bind:class="{ 'is-invalid' : decimalErr(entity.quantity, 'Daudzums tonnās(t)') }"
            debounce="250"
            v-model="entity.quantity"/>
        </b-form-group>

        <b-form-group :invalid-feedback="decimalErr(entity.sell_price, 'EUR/t')">
          <label>Pārdošanas cena EUR par tonnu(t)</label>
          <b-form-input type="text" placeholder="EUR/t"
            :class="{ 'is-invalid' : decimalErr(entity.sell_price, 'EUR/t') }"
            debounce="250"
            v-model="entity.sell_price"/>
        </b-form-group>
        
        <b-form-group :invalid-feedback="fErr(entity.date_from, 'Sākuma datums')">
          <label>Sākuma datums</label>
          <b-form-input type="date" placeholder="Sākuma datums"
            :class="{ 'is-invalid' : fErr(entity.date_from, 'Sākuma datums') }"
            debounce="250"
            v-model="entity.date_from"/>
        </b-form-group>

        <b-form-group :invalid-feedback="fErr(entity.date_to, 'Noslēguma datums')">
          <label>Noslēguma datums</label>
          <b-form-input type="date" placeholder="Noslēguma datums"
            :class="{ 'is-invalid' : fErr(entity.date_to, 'Noslēguma datums') }"
            debounce="250"
            v-model="entity.date_to"/>
        </b-form-group>
      </div>
      <div slot="footer">
        <b-button :to="{ name: 'Harvest', params:{field_id: this.$route.params.field_id, page: 1 } }" type="reset" variant="primary" >
          Atcelt
        </b-button>
        <b-button type="submit" variant="primary" :disabled="spinners.isSaving" @click="save()" class="ml-5">
          <b-spinner v-if="spinners.isSaving" type="grow" small/>
          Saglabāt
        </b-button>
      </div>
    </b-card>
  </div>
</template>

<script>
import merge from 'lodash.merge';
import Services from '@/services/index';
import ErrorMixin from '@/mixins/ErrorMixin';
import AlertMixin from '@/mixins/AlertMixin';

export default {
  mounted() {
    this.load();
  },
  data() {
    return {
      spinners: {
        contentIsLoading: false,
        isSaving: false,
      },
      entity: this.value,
      errorMsg: this.errors,
    };
  },
  props: {
    // If id === null, form will be considered create form else update
    id: { type: Number, default: null },
    // if title == false to hide header, pass string to override default title
    title: { type: [String, Boolean], default: undefined },
    // pass errors from parent form if embedded
    errors: { type: Object, default() { return {}; } },
    // value is used both as DEFAULTs placeholder and for v-model
    value: {
      type: Object,
      default() {
        return {
          quantity: null,
          sell_price: null,
          date_from: null,
          date_to: null,
          field_id: this.$route.params.field_id,
        };
      },
    },
  },
  components: {
  },
  computed: {
    // embedded form will have value passed using v-model, we could also make a custom prop for checking this
    isEmbedded() { return this.$options.propsData.value !== undefined; },
    isUpdateForm() { return this.id !== null; },
  },
  methods: {
    getForUpdate: Services.harvest.editData,
    getForCreate: Services.harvest.createData,
    pushUpdate: Services.harvest.update,
    pushCreate: Services.harvest.create,
    load() {
      this.spinners.contentIsLoading = true;
      const action = this.isUpdateForm ? this.getForUpdate : this.getForCreate;
      action(this.$route.params.id).then((data) => {
        this.spinners.contentIsLoading = false;
        this.entity = this.isUpdateForm ? data.data.harvest : { ...this.entity, ...data.data.harvest };
      }).catch((data) => {
        this.spinners.contentIsLoading = false;
        this.errorMsg = data.data ? data.data.errors : {};
      });
    },
    save() {
      if (this.entity.quantity === null) { this.entity.quantity = ""; }
      if (this.entity.sell_price === null) { this.entity.sell_price = ""; }
      if (this.entity.date_from === null) { this.entity.date_from = ""; }
      if (this.isEmbedded) return;
      this.spinners.isSaving = true;
      const action = this.isUpdateForm ? this.pushUpdate : this.pushCreate;
      action(this.entity).then((data) => {
        this.spinners.isSaving = false;
        setTimeout(() => {
          if (this.isUpdateForm) {
            this.alertSuccess({text: 'Ražas dati rediģēti veiksmīgi!'});
          } else {
            this.alertSuccess({text: 'Ražas dati pivienoti veiksmīgi!'});
          }
        }, 10);
        // this.entity = data.data; // This wont work if entity has nested objects/forms
        merge((this.entity), data.data); // This will not delete keys but will preserve original object
        this.errorMsg = {};
        this.$router.push({ name: 'Harvest', params: { field_id: this.entity.field_id, page: 1 }});
      }).catch(({ errors, message }) => {
        this.spinners.isSaving = false;
        this.errorMsg = errors;
        this.alertError({ text: message });
      });
    },
  },
  mixins: [ErrorMixin, AlertMixin]
};
</script>

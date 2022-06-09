<template>
  <div class="animated fadeIn">
    <b-card>
      <div slot="header">
        <b-row>
          <b-col cols="6">
            <span v-if="isUpdateForm">{{'Update field actions' }}</span>
            <span v-else>{{ 'Create field actions' }}</span>
          </b-col>
        </b-row>
      </div>
      <div v-if="spinners.contentIsLoading" class="text-center">
        <b-spinner type="grow" variant="primary"/>
      </div>
      <div v-else>
        <b-form-group :invalid-feedback="fErr(entity.action_type, '\'Darbības tips\'')">
          <label>Darbības tips</label>
          <b-form-input type="text" placeholder="Darbības tips"
            :class="{ 'is-invalid' : fErr(entity.action_type, '\'Darbības tips\'') }"
            debounce="250"
            v-model="entity.action_type"/>
        </b-form-group>

        <b-form-group :invalid-feedback="costErr(entity.cost, 'Izmaksas EUR')">
          <label>Izmaksas EUR</label>
          <b-form-input type="text" placeholder="Izmaksas EUR"
            :class="{ 'is-invalid' : costErr(entity.cost, 'Izmaksas EUR') }"
            debounce="250"
            v-model="entity.cost"/>
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
        <b-button :to="{ name: 'Fields', params:{ page: 1 } }" type="reset" variant="primary" >
          Atcelt
        </b-button>
        <b-button type="submit" variant="primary" :disabled="spinners.isSaving" @click="save()" class="ml-5">
          <b-spinner v-if="spinners.isSaving" type="grow" small/>
          Saglabāt
        </b-button>

        <!-- <b-button type="submit" variant="primary" :disabled="spinners.isSaving" @click="save()">
          <b-spinner v-if="spinners.isSaving" type="grow" small/>
          {{ 'Saglabāt' }}
        </b-button>
        <router-view :to="{ name: 'FieldActions' }">
          <b-button type="reset" variant="info" class="ml-2">
            {{ 'Atcelt' }}
          </b-button> -->
        <!-- </router-view> -->
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
          action_type: null,
          cost: null,
          date_from: null,
          date_to: null,
          fields_id: this.$route.params.field_id,
        };
      },
    },
  },
  computed: {
    // embedded form will have value passed using v-model, we could also make a custom prop for checking this
    isEmbedded() { return this.$options.propsData.value !== undefined; },
    isUpdateForm() { return this.id !== null; },
  },
  methods: {
    getForUpdate: Services.fieldactions.editData,
    getForCreate: Services.fieldactions.createData,
    pushUpdate: Services.fieldactions.update,
    pushCreate: Services.fieldactions.create,
    load() {
      this.spinners.contentIsLoading = true;
      const action = this.isUpdateForm ? this.getForUpdate : this.getForCreate;
      action(this.$route.params.id).then((data) => {
        this.spinners.contentIsLoading = false;
        this.entity = this.isUpdateForm ? data.data.fieldactions : { ...this.entity, ...data.data.fieldactions };
      }).catch((data) => {
        this.spinners.contentIsLoading = false;
        this.errorMsg = data.data ? data.data.errors : {};
      });
    },
    // alertError(AlertValue) {
    //   console.log(AlertValue);
    // },
    // alertSuccess() {
    //   window.alert('Field action added successfully');
    // },
    save() {
      if (this.entity.action_type === null) { this.entity.action_type = ""; }
      if (this.entity.date_from === null) { this.entity.date_from = ""; }
      if (this.isEmbedded) return;
      this.spinners.isSaving = true;
      const action = this.isUpdateForm ? this.pushUpdate : this.pushCreate;
      action(this.entity).then((data) => {
        this.spinners.isSaving = false;
        setTimeout(() => {
          if (this.isUpdateForm) {
            this.alertSuccess({text: 'Darbības dati rediģēti veiksmīgi!'});
          } else {
            this.alertSuccess({text: 'Darbības dati pivienoti veiksmīgi!'});
          }
        }, 10);
        // this.entity = data.data; // This wont work if entity has nested objects/forms
        merge(this.entity, data.data); // This will not delete keys but will preserve original object
        this.errorMsg = {};
        // if (!this.isUpdateForm) {
        //   // After successful create
        //   // if (this.$can('edit', 'fields')) {
        //   if (this.id != null) {
        //     this.$router.push({ name: 'FieldActionsUpdate', params: { id: data.data.id } });
        //   }
        //   else { // do not redirect if cannot edit
        //     this.entity = this.$options.props.value.default();
        //     this.load();
        //   }
        // }
        this.$router.push({ name: 'FieldActions', params: { field_id: this.entity.field_id, page: 1 }});
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

<style scoped>
</style>

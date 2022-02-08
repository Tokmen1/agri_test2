<template>
  <div class="animated fadeIn">
    <b-card>
      <div slot="header">
        <b-row>
          <b-col cols="6">
            <span v-if="isUpdateForm">Rediģēt lauka datus</span>
            <span v-else>Izveidot datus par lauku</span>
          </b-col>
        </b-row>
      </div>
      <div v-if="spinners.contentIsLoading" class="text-center">
        <b-spinner type="grow" variant="primary"/>
      </div>
      <div v-else>
        <b-form-group :invalid-feedback="fErr(entity.field_name, 'Lauka nosaukums')">
          <label>{{ 'Lauka nosaukums' }}</label>
          <b-form-input type="text" placeholder="Lauka nosaukums"
            :class="{ 'is-invalid' : fErr(entity.field_name, 'Lauka nosaukums') }"
            debounce="250"
            v-model="entity.field_name"/>
        </b-form-group>
        <b-form-group :invalid-feedback="decimalErr(entity.area, 'Lauka platība')">
          <label>{{ 'Lauka platība' }}</label>
          <b-form-input type="text" placeholder="Lauka platība"
            :class="{ 'is-invalid' : decimalErr(entity.area, 'Lauka platība') }"
            debounce="250"
            v-model="entity.area"/>
        </b-form-group>
      </div>
      <div slot="footer">
        <b-button :to="{ name: 'Fields', params:{ page:1 }}" type="reset" variant="primary" class="mx-5">
          Atcelt
        </b-button>
        <b-button type="submit" variant="primary" :disabled="spinners.isSaving" @click="save()" class="mx-5">
          <b-spinner v-if="spinners.isSaving" type="grow" small/>
          Saglabāt
        </b-button>
      </div>
    </b-card>
  </div>
</template>

<script>
import ErrorMixin from '@/mixins/ErrorMixin';
import Services from '@/services/index';
import merge from 'lodash.merge';

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
    field_id: { type: Number, default: null },
    // if title == false to hide header, pass string to override default title
    title: { type: [String, Boolean], default: undefined },
    // pass errors from parent form if embedded
    errors: { type: Object, default() { return {}; } },
    // value is used both as DEFAULTs placeholder and for v-model
    value: {
      type: Object,
      default() {
        return {
          field_name: null,
          area: null,
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
    getForUpdate: Services.fields.editData,
    getForCreate: Services.fields.createData,
    pushUpdate: Services.fields.update,
    pushCreate: Services.fields.create,
    load() {
      this.spinners.contentIsLoading = true;
      const action = this.isUpdateForm ? this.getForUpdate : this.getForCreate;
      action(this.$route.params.id).then((data) => {
        this.spinners.contentIsLoading = false;
        // data.data.field = {id:this.$route.params.id, field_name: "kkkkka", area: 22, created_at: 12,updated_at: 10};
        this.entity = this.isUpdateForm ? data.data.field : { ...this.entity, ...data.data.field };
      }).catch((data) => {
        this.spinners.contentIsLoading = false;
        this.errorMsg = data.data ? data.data.errors : {};
      });
    },
    alertError(AlertValue) {
      console.log(AlertValue);
    },
    alertSuccess() {
      window.alert('Field added successfully');
    },
    save() {
      if (this.isEmbedded) return;
      this.spinners.isSaving = true;
      const action = this.isUpdateForm ? this.pushUpdate : this.pushCreate;
      action(this.entity).then((data) => {
        this.spinners.isSaving = false;
        this.alertSuccess();
        // this.entity = data.data; // This wont work if entity has nested objects/forms
        merge(this.entity, data.data); // This will not delete keys but will preserve original object
        this.errorMsg = {};
        this.$router.push({ name: 'Fields', params: { page: 1 }});
        // if (!this.isUpdateForm) {
        // After successful create
        // if (this.$can('edit', 'fields')) {
        // if (this.id !== null) {
        //   this.$router.push({ name: 'FieldUpdate', params: { id: data.data.id } });
        // } else { // do not redirect if cannot edit
        //   this.entity = this.$options.props.value.default();
        //   this.load();
        // }
        // }
      }).catch(({ errors, message }) => {
        this.spinners.isSaving = false;
        this.errorMsg = errors;
        this.alertError({ text: message });
      });
    },
  },
  mixins: [ErrorMixin]
};
</script>

<style scoped>
</style>

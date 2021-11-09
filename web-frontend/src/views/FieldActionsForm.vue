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
        <b-form-group :invalid-feedback="fErr(entity.action_type, '\'Action type\'')">
          <label>{{ 'Action type' }}</label>
          <b-form-input type="text" placeholder="Action type"
            :class="{ 'is-invalid' : fErr(entity.action_type, '\'Action type\'') }"
            v-model="entity.action_type"/>
        </b-form-group>
        <b-form-group :invalid-feedback="fErr(entity.date_from, '\'Date from\'')">
          <label>{{ 'Date from' }}</label>
          <b-form-input type="text" placeholder="Date from"
            :class="{ 'is-invalid' : fErr(entity.date_from, '\'Date from\'') }"
            v-model="entity.date_from"/>
        </b-form-group>
        <b-form-group :invalid-feedback="fErr(entity.date_to, '\'Date to\'')">
          <label>{{ 'Date to' }}</label>
          <b-form-input type="text" placeholder="Date to"
            :class="{ 'is-invalid' : fErr(entity.date_to, '\'Date to\'') }"
            v-model="entity.date_to"/>
        </b-form-group>
      </div>
      <div slot="footer">
        <b-button type="submit" variant="primary" :disabled="spinners.isSaving" @click="save()">
          <b-spinner v-if="spinners.isSaving" type="grow" small/>
          {{ 'global.save' }}
        </b-button>
        <router-view :to="{ name: 'FieldActions' }">
          <b-button type="reset" variant="info" class="ml-2">
            {{ 'global.cancel' }}
          </b-button>
        </router-view>
      </div>
    </b-card>
  </div>
</template>

<script>
import merge from 'lodash.merge';
import Services from '@/services/index';

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
    //fields_id: { type: String, default: null } ,
    // if title == false to hide header, pass string to override default title
    title: { type: [String, Boolean], default: undefined },
    // pass errors from parent form if embedded
    errors: { type: Object, default() { return {}; } },
    // value is used both as DEFAULTs placeholder and for v-model
    value: {
      type: Object,
      default() {
        return {
          action_type: '',
          date_from: null,
          date_to: null,
          fields_id: this.$route.params.field_id,
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
    getForUpdate: Services.fieldactions.editData,
    getForCreate: Services.fieldactions.createData,
    pushUpdate: Services.fieldactions.update,
    pushCreate: Services.fieldactions.create,
    load() {
      //this.entity.fields_id = this.$route.params.field_id;
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
    fErr (ErrValue, name) {
      if (ErrValue === null || ErrValue == ""){
        return name+" value is required!";
      }
      else if(name == 'Area' && parseFloat(ErrValue) != ErrValue ){
        return "Please enter valid "+name+" (number or decimal with '.')!";
      }
      else if (name == 'Area'){
        return '';
      }
    },
    alertError(AlertValue){
      console.log(AlertValue);
    },
    alertSuccess(){
      window.alert("Field action added successfully");
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
        if (!this.isUpdateForm) {
          // After successful create
          // if (this.$can('edit', 'fields')) {
          if(this.id != null){
            this.$router.push({ name: 'FieldActionsUpdate', params: { id: data.data.id } });
          }
          else{ // do not redirect if cannot edit
            this.entity = this.$options.props.value.default();
            this.load();
          }
        }
      }).catch(({ errors, message }) => {
        this.spinners.isSaving = false;
        this.errorMsg = errors;
        this.alertError({ text: message });
      });
    },
  }
};
</script>

<style scoped>
</style>

<template>
  <div class="animated fadeIn">
    <b-card>
      <div slot="header">
        <b-row>
          <b-col cols="6">
            <span v-if="isUpdateForm">{{'field.update_title' }}</span>
            <span v-else>{{ 'field.create_title' }}</span>
          </b-col>
        </b-row>
      </div>
      <div v-if="spinners.contentIsLoading" class="text-center">
        <b-spinner type="grow" variant="primary"/>
      </div>
      <div v-else>
        <b-form-group invalid-feedback="Enter field name value">
          <label>{{ 'field.name' }}</label>
          <b-form-input type="text" placeholder="field.name_placeholder"
            :class="{ 'is-invalid' : fErr(entity.field_name) }"
            v-model="entity.field_name"/>
        </b-form-group>
        <b-form-group invalid-feedback="Enter area value">
          <label>{{ 'field.area' }}</label>
          <b-form-input type="text" placeholder="field.area_placeholder"
            :class="{ 'is-invalid' : fErr(entity.area) }"
            v-model="entity.area"/>
        </b-form-group>
      </div>
      <div slot="footer">
        <b-button type="submit" variant="primary" :disabled="spinners.isSaving" @click="save()">
          <b-spinner v-if="spinners.isSaving" type="grow" small/>
          {{ 'global.save' }}
        </b-button>
        <router-view :to="{ name: 'Fields' }">
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
    // if title == false to hide header, pass string to override default title
    title: { type: [String, Boolean], default: undefined },
    // pass errors from parent form if embedded
    errors: { type: Object, default() { return {}; } },
    // value is used both as DEFAULTs placeholder and for v-model
    value: {
      type: Object,
      default() {
        return {
          field_name: '',
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
        this.entity = this.isUpdateForm ? data.data.field : { ...this.entity, ...data.data.field };

      }).catch((data) => {
        this.spinners.contentIsLoading = false;
        this.errorMsg = data.data ? data.data.errors : {};
      });
    
    },
    fErr (ErrValue) {
      if (ErrValue === null || ErrValue == ""){
        return ErrValue+" value is required!";
      }
      else{
        console.log(ErrValue);
      }
    },
    alertError(AlertValue){
      console.log(AlertValue);
    },
    alertSuccess(){
      window.alert("Field added successfully");
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
          if(this.id !== null){
            this.$router.push({ name: 'FieldUpdate', params: { id: data.data.id } });
          }
          else{
            this.entity = this.$options.props.value.default();
            this.load();
          }
          // } else { // do not redirect if cannot edit
          //   this.entity = this.$options.props.value.default();
          //   this.load();
          // }
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

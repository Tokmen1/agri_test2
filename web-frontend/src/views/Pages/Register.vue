<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="6" sm="8">
          <b-card no-body class="mx-4">
            <b-card-body class="p-4">
              <b-form>
                <h1>{{ 'auth.register_title' }}</h1>
                <p class="text-muted">{{ 'auth.register_description' }}</p>
                <b-input-group class="mb-3">
                  <b-input-group-prepend>
                    <b-input-group-text><i class="icon-user"/></b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input ref="name" type="text" class="form-control"
                                placeholder="global.name"
                                :class="{ 'is-invalid' : errorMsg.name }"
                                v-model="name"/>
                  <div class="invalid-feedback" v-if="errorMsg.name">{{ errorMsg.name[0] }}</div>
                </b-input-group>
                <b-input-group class="mb-3">
                  <b-input-group-prepend>
                    <b-input-group-text><i class="icon-user"/></b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input type="text" class="form-control"
                                placeholder="global.surname"
                                :class="{ 'is-invalid' : errorMsg.surname }"
                                v-model="surname"/>
                  <div class="invalid-feedback" v-if="errorMsg.surname">{{ errorMsg.surname[0] }}</div>
                </b-input-group>

                <b-input-group class="mb-3">
                  <b-input-group-prepend>
                    <b-input-group-text>@</b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input type="text" class="form-control"
                                placeholder="global.email"
                                :class="{ 'is-invalid' : errorMsg.email }"
                                v-model="email"/>
                  <div class="invalid-feedback" v-if="errorMsg.email">{{ errorMsg.email[0] }}</div>
                </b-input-group>

                <b-input-group class="mb-3">
                  <b-input-group-prepend>
                    <b-input-group-text><i class="icon-lock"></i></b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input type="password" class="form-control"
                                placeholder="global.password"
                                :class="{ 'is-invalid' : errorMsg.password }"
                                v-model="password"/>
                  <div class="invalid-feedback" v-if="errorMsg.password">{{ errorMsg.password[0] }}</div>
                </b-input-group>

                <b-input-group class="mb-4">
                  <b-input-group-prepend>
                    <b-input-group-text><i class="icon-lock"></i></b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input type="password" class="form-control"
                                placeholder="global.password_repeat"
                                :class="{ 'is-invalid' : errorMsg.password_confirmation }"
                                v-model="password_confirmation"/>
                  <div class="invalid-feedback" v-if="errorMsg.password_confirmation">
                    {{ errorMsg.password_confirmation[0] }}
                  </div>
                </b-input-group>
                <b-button variant="success" block @click="onRegister()">
                  {{ 'Create account' }}
                </b-button>
                <b-row>
                  <b-col cols="12" class="text-center">
                    <b-button variant="link" class="px-0"
                              :to="{ name: 'Login' }">
                      {{ 'auth.already_have_account_link' }}
                    </b-button>
                  </b-col>
                </b-row>
              </b-form>
            </b-card-body>
          </b-card>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
import Services from '@/services/index';

export default {
  mounted() {
    this.$refs.name.$el.focus();
  },
  data() {
    return {
      name: '',
      surname: '',
      email: '',
      password: '',
      password_confirmation: '',
      errorMsg: {}
    };
  },
  computed: {
  },
  watch: {
    register: 'onRegisterResponse',
  },
  methods: {
    onRegister() {
      try {
        Services.auth.register({
        name: this.name,
        surname: this.surname,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation
      })
        // this.$router.push({ name: 'Login' });
      } catch (error) {
        console.log(error);
      }
        // name: this.name,
        // surname: this.surname,
        // email: this.email,
        // password: this.password,
        // password_confirmation: this.password_confirmation
    },
    onRegisterResponse() {
      this.errorMsg = {};
      // if (this.register.status === statuses.LOADED) {
      //   this.$router.push({ name: 'Login' });
      // } else if (this.register.status === statuses.ERROR) {
      //   this.errorMsg = this.register.data.data.errors;
      // }
    },
  }
};

</script>

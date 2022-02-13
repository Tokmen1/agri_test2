<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col cols="8" lg="4">
          <b-card-group>
            <b-card no-body class="p-4">
              <b-card-body>
                <b-form name="login">
                  <h1>{{ 'Ienākt' }}</h1>
                  <p v-show="!isLoginFailed" class="text-muted">
                    <!-- {{ 'Login description' }} -->
                  </p>
                  <p v-show="isLoginFailed" class="text-danger">{{ 'Ieeja nav izdevusies' }}</p>
                  <b-input-group class="mb-3">
                    <b-input-group-prepend>
                      <b-input-group-text><b-icon icon="envelope"></b-icon></b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input ref="email" @keydown.enter.native="attemptLogin" v-model="email"
                                  type="text" class="form-control"
                                  placeholder="E-pasts"
                                  debounce="250"
                                  autocomplete="username-email"/>
                  </b-input-group>
                  <b-input-group class="mb-4">
                    <b-input-group-prepend><b-input-group-text>
                      <b-icon icon="lock"/></b-input-group-text>
                    </b-input-group-prepend>
                    <b-form-input @keydown.enter.native="attemptLogin" name="password" v-model="password"
                                  type="password" class="form-control"
                                  placeholder="Parole"
                                  debounce="250"
                                  autocomplete="current-password" />
                  </b-input-group>
                  <b-row>
                    <b-col cols="12">
                      <b-button-group class="d-flex">
                        <!-- <LanguagesDropdown/> -->
                        <b-button name="login" block variant="primary" class="px-4 w-100" @click="attemptLogin()"
                                  :disabled="isLoading">{{ 'Ienākt' }}</b-button>
                      </b-button-group>
                    </b-col>
                  </b-row>
                  <b-row>
                    <b-col cols="6" class="text-left">
                      <b-button variant="link" class="px-0"
                                :to="{ name: 'Register' }">{{ 'Reģistrēties' }}</b-button>
                    </b-col>
                    <!-- <b-col cols="6" class="text-right">
                      <b-button variant="link" class="px-0"
                                :to="{ name: 'PasswordForgot' }">
                        {{ 'auth.forgot_password_link' }}
                      </b-button>
                    </b-col> -->
                  </b-row>
                </b-form>
              </b-card-body>
            </b-card>
          </b-card-group>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>

import AuthService from '@/services/auth';

export default {
  mounted() {
    this.$refs.email.$el.focus();
  },
  data() {
    return {
      email: '',
      password: '',
      isLoading: false,
      isLoginFailed: false,
    };
  },
  components: {
    // LanguagesDropdown
  },
  computed: {
  },
  // watch: {
  //   user: {
  //     handler: function() {
  //       this.onUserChanged();
  //     },
  //     deep: true
  //   },
  // },
  methods: {
    attemptLogin() {
      this.isLoading = true;
      AuthService.login(this.email, this.password).then(({ data }) => {
        // const redirectPath = sessionStorage.getItem('redirectPath');
        sessionStorage.setItem('access_token', data['access_token']);
        sessionStorage.setItem('access_token_exp', data['expires_in']);
        // if (redirectPath !== null) {
        //   sessionStorage.removeItem('redirectPath');
        //   this.$router.push({ path: redirectPath });
        //   this.$router.go();
        // } else {
        //   this.$router.push({ name: 'Fields', params: { page: 1 } });
        // }
        this.$router.push({ name: 'Fields', params: { page: 1 } });
      }, () => {
        this.isLoginFailed = true;
        this.isLoading = false;
      });
    },
    // onUserChanged() {
    //   this.isLoading = false;
    //   if (this.user) {
    //     const redirectPath = sessionStorage.getItem('redirectPath');
    //     if (redirectPath) {
    //       sessionStorage.removeItem('redirectPath');
    //       this.$router.replace({ path: redirectPath });
    //     } else {
    //       this.$router.replace({ name: 'Fields', params: { page: 1 } });
    //     }
    //   }
    // },
  }
};
</script>

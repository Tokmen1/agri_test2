<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="6" sm="8">
          <b-card no-body class="mx-4">
            <b-card-body class="p-4">
              <b-form>
                <h1>{{ 'auth register title' }}</h1>
                <p class="text-muted">{{ 'auth register description' }}</p>
                <b-input-group class="mb-3">
                  <b-input-group-prepend>
                    <b-input-group-text><i class="icon-user"/></b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input ref="name" type="text" class="form-control"
                                placeholder="Name"
                                :class="{ 'is-invalid' : errorMsg.name }"
                                v-model="name"/>
                  <div class="invalid-feedback" v-if="errorMsg.name">{{ fErr(name, 'Name') }}</div>
                </b-input-group>
                <b-input-group class="mb-3">
                  <b-input-group-prepend>
                    <b-input-group-text><i class="icon-user"/></b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input type="text" class="form-control"
                                placeholder="Surname"
                                :class="{ 'is-invalid' : errorMsg.surname }"
                                v-model="surname"/>
                  <div class="invalid-feedback" v-if="errorMsg.surname">{{ fErr(surname, 'Surname') }}</div>
                </b-input-group>

                <b-input-group class="mb-3">
                  <b-input-group-prepend>
                    <b-input-group-text>@</b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input type="text" class="form-control"
                                placeholder="Email"
                                :class="{ 'is-invalid' : errorMsg.email }"
                                v-model="email"/>
                  <div class="invalid-feedback" v-if="errorMsg.email">{{ fErr(email, 'Email') }}</div>
                </b-input-group>

                <b-input-group class="mb-3">
                  <b-input-group-prepend>
                    <b-input-group-text><i class="icon-lock"></i></b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input type="password" class="form-control"
                                placeholder="Password"
                                :class="{ 'is-invalid' : errorMsg.password }"
                                
                                v-model="password"/>
                  <div class="invalid-feedback" v-if="errorMsg.password">{{ fErr(password, 'Password') }}</div>
                </b-input-group>

                <b-input-group class="mb-4">
                  <b-input-group-prepend>
                    <b-input-group-text><i class="icon-lock"></i></b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input type="password" class="form-control"
                                placeholder="Password repeat"
                                :class="{ 'is-invalid' : errorMsg.password_confirmation }"
                                
                                v-model="password_confirmation"/>
                  <div class="invalid-feedback" v-if="errorMsg.password_confirmation || password !== password_confirmation">
                    {{ fErr(password_confirmation, 'Password confirmation') ||  password_conf() }}
                  </div>
                </b-input-group>
                <b-button variant="success" block @click="onRegister()">
                  {{ 'Create account' }}
                </b-button>
                <b-row>
                  <b-col cols="12" class="text-center">
                    <b-button variant="link" class="px-0"
                              :to="{ name: 'Login' }">
                      {{ 'Already have an account' }}
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
import ErrorMixin from '@/mixins/ErrorMixin';

export default {
  mounted() {
    // this.$refs.name.$el.focus();
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
      Services.auth.register({
        name: this.name,
        // surname: this.surname,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation
      }).then(() => {
        this.$router.push({ name: 'Login' });
      }, () => {
        this.errorMsg = {};
        if ( this.fErr( this.name, 'Name' )) {
          this.errorMsg.name = true;
        }
        if ( this.fErr(this.email, 'Email')) {
          this.errorMsg.email = true;
        }
        if ( this.fErr(this.password, 'Password')) {
          this.errorMsg.password = true;
        }
        if ( this.fErr(this.password_confirmation, 'Password confirmation')) {
          this.errorMsg.password_confirmation = true;
        }
        if ( this.password !== this.password_confirmation ) {
          this.errorMsg.password_confirmation = true;
        }
      });
    },
    onRegisterResponse() {
      this.errorMsg = {};
      this.errorMsg = this.register.data.data.errors;
      console.log(this.errorMsg);
      // if (this.register.status === statuses.LOADED) {
      //   this.$router.push({ name: 'Login' });
      // } else if (this.register.status === statuses.ERROR) {
      //   this.errorMsg = this.register.data.data.errors;
      // }
    },
    password_conf() {
      if (this.password !== this.password_confirmation) {
        return 'This field must be identical to password field';
      }
    }
  },
  mixins: [ErrorMixin]
};

</script>

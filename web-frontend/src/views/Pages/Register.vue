<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="6" sm="8">
          <b-card no-body class="mx-4">
            <b-card-body class="p-4">
              <b-form>
                <h1>{{ 'Reģistrēties' }}</h1>
                <p class="text-muted">
                  <!-- {{ 'auth register description' }} -->
                </p>
                <b-input-group class="mb-3">
                  <b-input-group-prepend>
                    <b-input-group-text><b-icon icon="person"/></b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input ref="name" type="text" class="form-control"
                                placeholder="Vārds"
                                :class="{ 'is-invalid' : errorMsg.name && fErr(name, 'Vārds') }"
                                debounce="250"
                                v-model="name"/>
                  <div class="invalid-feedback" v-if="errorMsg.name">{{ fErr(name, 'Vārds') }}</div>
                </b-input-group>
                <!-- <b-input-group class="mb-3">
                  <b-input-group-prepend>
                    <b-input-group-text><b-icon icon="person-fill"/></b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input type="text" class="form-control"
                                placeholder="Uzvārds"
                                :class="{ 'is-invalid' : errorMsg.surname }"
                                debounce="250"
                                v-model="surname"/>
                  <div class="invalid-feedback" v-if="errorMsg.surname">{{ fErr(surname, 'Uzvārds') }}</div>
                </b-input-group> -->

                <b-input-group class="mb-3">
                  <b-input-group-prepend>
                    <b-input-group-text>@</b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input type="text" class="form-control"
                                placeholder="E-pasts"
                                :class="{ 'is-invalid' : errorMsg.email && emailErr(email, 'E-pasts')}"
                                debounce="250"
                                v-model="email"/>
                  <div class="invalid-feedback" v-if="errorMsg.email">{{ emailErr(email, 'E-pasts') }}</div>
                </b-input-group>

                <b-input-group class="mb-3">
                  <b-input-group-prepend>
                    <b-input-group-text><b-icon icon="lock" /></b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input type="password" class="form-control"
                                placeholder="Parole"
                                :class="{ 'is-invalid' : errorMsg.password && fErr(password, 'Parole')}"
                                debounce="250"        
                                v-model="password"/>
                  <div class="invalid-feedback" v-if="errorMsg.password">{{ fErr(password, 'Parole') }}</div>
                </b-input-group>

                <b-input-group class="mb-4">
                  <b-input-group-prepend>
                    <b-input-group-text><b-icon icon="lock-fill"/></b-input-group-text>
                  </b-input-group-prepend>
                  <b-form-input type="password" class="form-control"
                                placeholder="Apstiprini paroli"
                                :class="{ 'is-invalid' : errorMsg.password_confirmation }"
                                debounce="250"
                                v-model="password_confirmation"/>
                  <div class="invalid-feedback">
                    {{ fErr(password_confirmation, 'Paroles apstiprināšana') ||  this.password_conf() }}
                  </div>
                </b-input-group>
                <b-button type="submit" variant="success" block @click="onRegister()">
                  {{ 'Izveidot kontu' }}
                </b-button>
                <b-row>
                  <b-col cols="12" class="text-center">
                    <b-button variant="link" class="px-0"
                              :to="{ name: 'Login' }">
                      {{ 'Man jau ir izveidots konts' }}
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
        if ( this.fErr( this.name, 'Vārds' )) {
          this.errorMsg.name = true;
        }
        if ( this.emailErr(this.email, 'E-pasts')) {
          this.errorMsg.email = true;
        }
        if ( this.fErr(this.password, 'Parole')) {
          this.errorMsg.password = true;
        }
        if ( this.fErr(this.password_confirmation, 'Paroles apstiprināšana')) {
          this.errorMsg.password_confirmation = true;
        }
        if ( this.password !== this.password_confirmation || this.password_conf()) {
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
        return 'Šai vērtībai jābūt identiskai "Paroles" vērtībai';
      }
    }
  },
  mixins: [ErrorMixin]
};

</script>

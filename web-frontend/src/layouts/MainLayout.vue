<template>
  <div>
<b-navbar toggleable="lg" type="dark" variant="info">
    <router-link to="/"><b-navbar-brand>Lauku dati</b-navbar-brand></router-link>
    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
    <b-collapse id="nav-collapse" is-nav>
      <!-- <b-navbar-nav>
        <b-nav-item><router-link to="/example">Link</router-link></b-nav-item>
        <b-nav-item ><router-link to="/records">RECORDS</router-link></b-nav-item>
      </b-navbar-nav> -->

      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        <!-- <b-nav-form>
          <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
          <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
        </b-nav-form> -->

        <!-- <b-nav-item-dropdown text="Lang" right>
          <b-dropdown-item href="#">EN</b-dropdown-item>
          <b-dropdown-item href="#">LV</b-dropdown-item>
        </b-nav-item-dropdown> -->
<!-- Using 'button-content' slot -->
        <!-- <b-nav-item-dropdown right>
          
          <template #button-content>
            <em>User</em>
          </template>
          <b-dropdown-item href="#">Profile</b-dropdown-item>
        </b-nav-item-dropdown> -->
        <b-nav-item @click="sing_out()">
          <b >Iziet</b>
        </b-nav-item>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
  <router-view></router-view>
  <!-- {{ tokenExpiryDate }} -->
  </div>
</template>

<script>
import Services from '@/services';
import { backend } from '@/_axios';
export default {
  data() {
    return {
      tokenExpiryDate: sessionStorage.getItem('access_token_exp')
    };
  },
  watch: {
    tokenExpiryDate: {
      handler(value) {
        if (value > 1) {
          setTimeout(() => {
            this.tokenExpiryDate--;
            sessionStorage.setItem('access_token_exp', this.tokenExpiryDate);
          }, 1000);
        } else {
          this.sing_out();
        }
      },
      immediate: true
    }
  },
  methods: {
    sing_out() {
      (async () => {
        Services.auth.logout(sessionStorage.getItem('access_token'));
        await sessionStorage.removeItem('access_token');
        await sessionStorage.removeItem('access_token_exp');
        await delete backend.defaults.headers.common["Authorization"];
        this.$router.go();
      })();
      this.$router.replace({ name: 'Login' });
    }
  }
};
</script>

<style></style>

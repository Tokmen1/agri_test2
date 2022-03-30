export default {
  methods: {
    alertSuccess(params = {}) {
        this.$bvToast.toast(params['text'] || "Darbība izpildīta veiksmīgi!",{
            title: params['title'] || "Veiksmīgi izpildīts",
            variant: 'success',
            toaster: 'b-toaster-bottom-right',
            solid: true,
            appendToast: true
        })
    },
    alertError(params = {}) {
        this.$bvToast.toast(params['text'] || "Darbību nav iespējams izpildīt!",{
            title: params['title'] || "Kļūda",
            variant: 'danger',
            toaster: 'b-toaster-bottom-right',
            solid: true,
            appendToast: true
        })
    },  
  }
}
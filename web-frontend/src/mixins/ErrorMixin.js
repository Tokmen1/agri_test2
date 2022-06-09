export default {
  methods: {
    fErr(inputValue, fieldName) {
      if (inputValue == "") {
        return "Vērtība \""+fieldName+"\" jāievada obligāti!";
      }
    },
    decimalErr(inputValue, fieldName) {
      if (this.fErr(inputValue, fieldName)) {
        return this.fErr(inputValue, fieldName);
      } 
      if (inputValue !== null && parseFloat(inputValue) != inputValue ) {
        return "Ievadītā vērtība \""+fieldName+"\" ir nepareiza (Lūdzu, ievadiet vesalu skaitli vai decimāldaļu ar '.')!";
      }
      if (inputValue < 0) {
        return "Ievadītā vērtība \""+fieldName+"\" nedrīkst būt negatīva";
      }
    }, 
    costErr(inputValue, fieldName) {
      if (inputValue !== null && parseFloat(inputValue) != inputValue ) {
        return "Ievadītā vērtība \""+fieldName+"\" ir nepareiza (Lūdzu, ievadiet vesalu skaitli vai decimāldaļu ar '.')!";
      }
      if (inputValue < 0) {
        return "Ievadītā vērtība \""+fieldName+"\" nedrīkst būt negatīva";
      }
    }, 
    emailErr(inputValue, fieldName) {
      if (this.fErr(inputValue, fieldName)) {
        return this.fErr(inputValue, fieldName);
      } else {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!inputValue.match(re)) {
          return "Ievadītā e-pasta adrese ir nepareiza!";
        }
      }
    },
  }
};

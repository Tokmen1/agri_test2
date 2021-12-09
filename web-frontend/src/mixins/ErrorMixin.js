export default{
    methods: {
        fErr (ErrValue, name) {
            if (ErrValue === null || ErrValue == ""){
              return name+" value is required!";
            }
            if(name == 'Area' && parseFloat(ErrValue) != ErrValue ){
              return "Please enter valid "+name+" (number or decimal with '.')!";
            }
            if (name == 'Email') {
              const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
              if (!ErrValue.match(re)){
                return "Enter valid email address";
              }
            }
            // else if (name == 'Area'){
            //   return '';
            // }
          },
    }
}
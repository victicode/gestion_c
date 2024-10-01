const util = {
  numberFormat: (number) => {
      number = `${number}`;
      let formattedNumber = "";
      let newNumber = "";

      // Si el numero empieza por el valor "-" (numero negativo)
      // If the number starts with "-" is negative
      if(number[0] == "-") {
          newNumber = number.replace(/\,/g, '').substring(1); // replace all ',' with '' and not delete the negative symbol
      } else{
          newNumber = number.replace(/\,/g, ''); // replace all ',' with ''
      }

      // If the number has decimals
      if(number.indexOf(".") >= 0) {
          newNumber = newNumber.substring(0, newNumber.indexOf("."));
      }

      // Put '.' for each 3 characters
      for (var j, i = newNumber.length - 1, j = 0; i >= 0; i--, j++) {
          formattedNumber = newNumber.charAt(i) + ((j > 0) && (j % 3 == 0)? ".": "") + formattedNumber;
      }

      // If the number has decimals, push to the formattedNumber
      if(number.indexOf(".") >= 0){
          formattedNumber += number.substring(number.indexOf("."));
      }

      if(number[0] == "-") {
          return "-" + formattedNumber; // Return the value with negative symbol
      }

      return formattedNumber;
  },
  moneyFormat: (number) => {
    let money = 0;

    if(number > 999999 && number < 1000000000){
        money = `${(number/1000000).toFixed(1)}mill` 
    }
    else if(number > 999 && number < 999999){
        money = `${(number/1000).toFixed(1)}mil` 
    }
    else{
        money = number
    }
    return money
  }
}

export default util
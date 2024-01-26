function generateRandomNumber(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
  
function updateVisitors() {
  var visitorsSpan = document.getElementById("visitors");
  var randomNumber = generateRandomNumber(5, 100);
  visitorsSpan.textContent = randomNumber;
}
window.onload = updateVisitors;

document.addEventListener('DOMContentLoaded', function () {
  var form = document.forms[0];
  var submitButton = document.getElementById('valider');
  submitButton.disabled = true;
  form.addEventListener('change', function () {
      var formCompleted = isFormCompleted(form);
      submitButton.disabled = !formCompleted;
  });
  function isFormCompleted(form) {
      var formInputs = form.querySelectorAll('input, textarea, select');
      var atLeastOneCheckboxChecked = false;
      for (var i = 0; i < formInputs.length; i++) {
          if (formInputs[i].type === 'checkbox') {
              if (formInputs[i].checked) {
                  atLeastOneCheckboxChecked = true;
              }
          } else if (formInputs[i].hasAttribute('required') && formInputs[i].value === '') {
              return false;
          }
      }
      return atLeastOneCheckboxChecked;
  }
});
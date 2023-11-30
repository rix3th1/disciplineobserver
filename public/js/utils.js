'use strict'

const showPasswordSwitch = document.getElementById('showPassword')
// Seleccionar todos los inputs de tipo password y cambiar su tipo a texto cuando se activa el switch de mostrar contraseña.
const passwordInputs = document.querySelectorAll('input[type="password"]')

if (showPasswordSwitch) {
  showPasswordSwitch.addEventListener('change', function () {
    for (let i = 0; i < passwordInputs.length; i++) {
      passwordInputs[i].type = showPasswordSwitch.checked ? 'text' : 'password'
    }
  })
}

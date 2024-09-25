const loginForm = document.getElementById('loginForm');
const emailInput = document.getElementById('u_email');
const passwordInput = document.getElementById('u_pass');
const codeInput = document.getElementById('u_code');

const emailRegex = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
const passwordRegex = /^.{4,12}$/;
const codeRegex = /^.{1,}$/;

const showMessage = (input, message, isValid) => {
  const errorMessage = input.parentElement.querySelector('.error-message');
  errorMessage.innerText = message;
  errorMessage.style.color = isValid ? 'green' : 'red';
};

const validateEmail = () => {
  const isValid = emailRegex.test(emailInput.value);
  showMessage(emailInput, isValid ? '' : 'Ingresa un correo electrónico válido', isValid);
  return isValid;
};

const validatePassword = () => {
  const isValid = passwordRegex.test(passwordInput.value);
  showMessage(passwordInput, isValid ? '' : 'La contraseña debe tener entre 4 y 12 caracteres', isValid);
  return isValid;
};

const validateCode = () => {
  const isValid = codeRegex.test(codeInput.value);
  showMessage(codeInput, isValid ? '' : 'Ingresa un código de verificación válido', isValid);
  return isValid;
};

emailInput.addEventListener('input', validateEmail);
passwordInput.addEventListener('input', validatePassword);
codeInput.addEventListener('input', validateCode);

loginForm.addEventListener('submit', (e) => {
  if (!validateEmail() || !validatePassword() || !validateCode()) {
    e.preventDefault();
    alert('Por favor completa todos los campos correctamente.');
  }
});

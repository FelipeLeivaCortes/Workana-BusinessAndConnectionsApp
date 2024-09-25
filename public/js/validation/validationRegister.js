const register = document.getElementById("registerUser");
const inputs = document.querySelectorAll("#registerUser input");

const expresiones = {
  user: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
  name: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
  password: /^.{4,12}$/, // 4 a 12 digitos.
  email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
  phone: /^\d{7,14}$/, // 7 a 14 numeros.
  nit: /^\d{6,9}$/,
  numVerNIT: /^\d{1}$/,
};

const campos = {
  company_name: false,
  NIT: false,
  numVerNIT: false,
  industry: false,
  country: false,
  department: false,
  representative_name: false,
  representative_lastname: false,
  representative_document: false,
  representative_document_type: false,
  email: false,
  phone: false,
  password: false,
  confirm_password: false,
  rut: false,
  chamber_of_commerce: false,
  representative_cedula: false,
  form_inscription: false,
  certificate_bank: false,
  c_desc: false,
};

const validarmodal2 = (e) => {
  switch (e.target.name) {
    case "company_name":
      if (expresiones.name.test(e.target.value)) {
        document.getElementById("company_name").classList.remove("bad");
        document.getElementById("company_name").classList.add("good");
        campos["company_name"] = true;
      } else {
        document.getElementById("company_name").classList.add("bad");
        document.getElementById("company_name").classList.remove("good");
        campos["company_name"] = false;
      }
      break;
    case "industry":
      if (expresiones.name.test(e.target.value)) {
        document.getElementById("industry").classList.remove("bad");
        document.getElementById("industry").classList.add("good");
        campos["industry"] = true;
      } else {
        document.getElementById("industry").classList.add("bad");
        document.getElementById("industry").classList.remove("good");
        campos["industry"] = false;
      }
      break;
    case "representative_name":
      if (expresiones.name.test(e.target.value)) {
        document.getElementById("representative_name").classList.remove("bad");
        document.getElementById("representative_name").classList.add("good");
        campos["representative_name"] = true;
      } else {
        document.getElementById("representative_name").classList.add("bad");
        document.getElementById("representative_name").classList.remove("good");
        campos["representative_name"] = false;
      }
      break;
    case "email":
      if (expresiones.email.test(e.target.value)) {
        document.getElementById("email").classList.remove("bad");
        document.getElementById("email").classList.add("good");
        campos["email"] = true;
      } else {
        document.getElementById("email").classList.add("bad");
        document.getElementById("email").classList.remove("good");
        campos["email"] = false;
      }
      break;
    case "representative_lastname":
      if (expresiones.name.test(e.target.value)) {
        document
          .getElementById("representative_lastname")
          .classList.remove("bad");
        document
          .getElementById("representative_lastname")
          .classList.add("good");
        campos["representative_lastname"] = true;
      } else {
        document.getElementById("representative_lastname").classList.add("bad");
        document
          .getElementById("representative_lastname")
          .classList.remove("good");
        campos["representative_lastname"] = false;
      }
      break;
    case "representative_document":
      if (expresiones.phone.test(e.target.value)) {
        document
          .getElementById("representative_document")
          .classList.remove("bad");
        document
          .getElementById("representative_document")
          .classList.add("good");
        campos["representative_document"] = true;
      } else {
        document.getElementById("representative_document").classList.add("bad");
        document
          .getElementById("representative_document")
          .classList.remove("good");
        campos["representative_document"] = false;
      }
      break;
    case "phone":
      if (expresiones.phone.test(e.target.value)) {
        document.getElementById("phone").classList.remove("bad");
        document.getElementById("phone").classList.add("good");
        campos["phone"] = true;
      } else {
        document.getElementById("phone").classList.add("bad");
        document.getElementById("phone").classList.remove("good");
        campos["phone"] = false;
      }
      break;
    case "password":
      if (expresiones.password.test(e.target.value)) {
        document.getElementById("password").classList.remove("bad");
        document.getElementById("password").classList.add("good");
        campos["password"] = true;
      } else {
        document.getElementById("password").classList.add("bad");
        document.getElementById("password").classList.remove("good");
        campos["password"] = false;
      }
      break;
    case "confirm_password":
      const passwordValue = document.getElementById("password").value;
      if (e.target.value === passwordValue) {
        document.getElementById("confirm_password").classList.remove("bad");
        document.getElementById("confirm_password").classList.add("good");
        campos["confirm_password"] = true;
      } else {
        document.getElementById("confirm_password").classList.add("bad");
        document.getElementById("confirm_password").classList.remove("good");
        campos["confirm_password"] = false;
      }
      break;
    case "c_desc":
      if (expresiones.name.test(e.target.value)) {
        document.getElementById("c_desc").classList.remove("bad");
        document.getElementById("c_desc").classList.add("good");
        campos["c_desc"] = true;
      } else {
        document.getElementById("c_desc").classList.add("bad");
        document.getElementById("c_desc").classList.remove("good");
        campos["c_desc"] = false;
      }
      break;
    case "NIT":
      if (expresiones.nit.test(e.target.value)) {
        document.getElementById("NIT").classList.remove("bad");
        document.getElementById("NIT").classList.add("good");
        campos["NIT"] = true;
      } else {
        document.getElementById("NIT").classList.add("bad");
        document.getElementById("NIT").classList.remove("good");
        campos["NIT"] = false;
      }
    case "numVerNIT":
      if (expresiones.numVerNIT.test(e.target.value)) {
        document.getElementById("numVerNIT").classList.remove("bad");
        document.getElementById("numVerNIT").classList.add("good");
        campos["numVerNIT"] = true;
      } else {
        document.getElementById("numVerNIT").classList.add("bad");
        document.getElementById("numVerNIT").classList.remove("good");
        campos["numVerNIT"] = false;
      }
      break;
  }
};

const validarcorreos = () => {
  const inputcorreo = document.getElementById("password");
  const inputcorreo2 = document.getElementById("confirm_password");

  if (inputcorreo.value !== inputcorreo2.value) {
    document.getElementById("confirm_password").classList.add("procesomalo");
    document
      .getElementById("confirm_password")
      .classList.remove("procesobueno");
    document.querySelector("#contPass2 .error").classList.add("error-activo");
    campos["confirm_password"] = false;
  } else {
    document.getElementById("confirm_password").classList.remove("procesomalo");
    document.getElementById("confirm_password").classList.add("procesobueno");
    document
      .querySelector("#contPass2 .error")
      .classList.remove("error-activo");
    campos["confirm_password"] = true;
  }
};

// Ejecuta la función de validación en cada evento
inputs.forEach((input) => {
  input.addEventListener("keyup", validarmodal2);
  input.addEventListener("blur", validarmodal2);
  input.addEventListener("keyup", validarcorreos);
  input.addEventListener("blur", validarcorreos);
});

// Validación y envío del formulario
register.addEventListener("submit", (e) => {
  // Validar los campos restantes
  validarFormulario();

  // Comprobar si todos los campos son válidos
  for (const campo in campos) {
    if (!campos[campo]) {
      e.preventDefault();
      alert("No tiene completos los campos o son datos inválidos");
      return false;
    }
  }

  // Si todos los campos son válidos, permitir el envío del formulario
  return true;
});

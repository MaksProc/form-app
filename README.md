This is an exercise in Vue 3 and Symfony 7. This project serves a multi-step form designed in a modular way: each input and step is a separate component, inputs can use each other, common intentions are signalled via composables and a template file. Backend form validation is also separated in services that can be reused for different forms.

---

The form is available at /form (root route is not configured, debug mode is on).

Vue components are available at assets/components. Backend validator services are at src/Service.

---

External libraries used: Bootstrap

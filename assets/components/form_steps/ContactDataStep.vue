<!-- Second form step. Fields: phone number, e-mail -->

<script setup>
import { ref, onMounted } from 'vue';
import PhoneInput from '../form_inputs/contact/PhoneInput.vue';
import { useStepValidation } from './useStepValidation';

const phoneInput = ref();

const { registerInput, validateStep } = useStepValidation();

onMounted(() => {
    registerInput(phoneInput);
})

defineExpose({
    validateStep
})

</script>

<template>
    <PhoneInput label="Numer telefonu" id="phone" ref="phoneInput" />
</template>
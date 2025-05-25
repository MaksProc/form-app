<!-- Second form step. Fields: phone number, e-mail -->

<script setup>
import { ref, onMounted } from 'vue';
import PhoneInput from '../form_inputs/contact/PhoneInput.vue';
import { useStepValidation } from './useStepValidation';
import EmailInput from '../form_inputs/contact/EmailInput.vue';

const props = defineProps({
    required: {
        type: Boolean,
        default: false
    }
})

const phoneInput = ref();
const emailInput = ref();

const { registerInput, validateStep } = useStepValidation();

onMounted(() => {
    registerInput(phoneInput);
    registerInput(emailInput);
})

defineExpose({
    validateStep
})

</script>

<template>
    <PhoneInput label="Phone number" id="phone" ref="phoneInput" :required="required" />
    <EmailInput label="E-mail" id="email" ref="emailInput" :required="required" />
</template>
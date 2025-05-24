<!-- Form component for phone number input -->

<script setup>
import { useInputValidation } from '../useInputValidation';
import { ref } from 'vue';

const props = defineProps({
    label: {
        type: String,
        default: "Phone number"
    },
    id: {
        type: String,
        required: true
    }
})

const helpMsg = ref('');

const {value: phone, validate } = useInputValidation(val => {
    // Phone validity checks
    helpMsg.value = '';

    const digitsOnly = val.replace(/\D/g, '');
    if (!(digitsOnly.length >= 9 && digitsOnly.length <= 12)) {
        helpMsg.value = 'Phone number should be 9-12 numbers long'
    }
    
    if (helpMsg.value != '') return false;
    
    return true;
})

defineExpose({ validate });

// User experience
function onInput(e) {
    let raw = e.target.value;

    // 1. Allow only digits and optional leading plus
    let isPlus = raw[0] === '+';
    let digits = raw.replace(/\D/g, '');

    // 2. Limit to 12 symbols max
    if (isPlus) digits = digits.slice(0, 11)
    else digits = digits.slice(0, 12);

    // 3. Insert spaces every 3 digits for readability
    const groups = [];
    if (isPlus) {
        groups.push("+" + digits.slice(0, 2))
        for (let i = 2; i < digits.length; i += 3) {
            groups.push(digits.slice(i, i+3));
        }
    }
    else {
        for (let i = 0; i < digits.length; i += 3) {
            groups.push(digits.slice(i, i + 3));
        }
    }
        
    let formatted = groups.join(' ');

    phone.value = formatted;
}

</script>

<template>
    <div class="form-group">
        <label :for="id">{{ label }}</label>
        <input type="text" :id="id" v-model="phone" @input="onInput" class="form-control" inputmode="tel" autocomplete="tel" placeholder="+48 ___ ___ ___">
        <small class="form-text text-danger">{{ helpMsg }}</small>
    </div>
</template>
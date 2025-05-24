<!-- Form component for email input -->

<script setup>
import { ref } from 'vue';
import { useInputValidation } from '../useInputValidation';


const props = defineProps({
    label: {
        type: String,
        default: "E-mail address"
    },
    id: {
        type: String,
        required: true
    }
})

const helpMsg = ref('');

const { value: email, validate } = useInputValidation(val => {
    // Make validity checks here
    helpMsg.value = '';

    const trimmed = val.trim();
    if (!trimmed) return false;
    if (trimmed.length > 254) return false;
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(trimmed)) {
        helpMsg.value = 'Provide a valid e-mail address'
        return false;
    }
    else {
        return true;
    };
})

defineExpose({ validate });


// User experience
function onInput(e) {
    
}

</script>

<template>
    <div class="form-group">
        <label :for="id">{{ label }}: </label>
        <input type="email" :id="id" v-model="email" @input="onInput" class="form-control" autocomplete="email"/>
        <small class="form-text text-danger">{{ helpMsg }}</small>
    </div>
</template>
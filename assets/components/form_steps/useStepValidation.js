// Import this in form Step components

import { ref, isRef } from 'vue';

export function useStepValidation() {
    const inputs = ref([]);

    function registerInput(input) {
        const wrapped = isRef(input) ? input : ref(input);
        inputs.value.push(wrapped);
    }

    function validateStep() {
        return inputs.value.every(input => input.value.validate());
    }

    return { registerInput, validateStep }
}
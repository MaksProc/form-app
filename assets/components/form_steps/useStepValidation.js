// Import this in form Step components

import { ref } from 'vue';

export function useStepValidation() {
    const inputs = ref([]);

    function registerInput(input) {
        inputs.value.push(input);
    }

    function validateStep() {
        return inputs.value.every(input => input.value.validate());
    }

    return { registerInput, validateStep }
}
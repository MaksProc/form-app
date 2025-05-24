// Import this in Input components with validity checks function as argument


import { ref } from 'vue';

export function useInputValidation(
    validator = val => true, // The function that checks value. Default is all valid
    initial = ''
) {
    const value = ref(initial);
    const isValid = ref(true);

    function validate() {
        isValid.value = validator(value.value);
        return isValid.value;
    }

    return { value, isValid, validate }
}
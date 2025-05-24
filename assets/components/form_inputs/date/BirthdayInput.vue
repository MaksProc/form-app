<!-- Form input component for one date validated to be before today -->
<!-- Used for birthdays -->

<script setup>
import { useInputValidation } from '../useInputValidation';

const props = defineProps({
    label: {
        type: String,
        default: "Birthday"
    },
    id: {
        type: String,
        required: true
    }
})

const { value:date, validate } = useInputValidation(val => {
    const today = new Date().setHours(0, 0, 0, 0)
    const chosenDate = new Date(Date.parse(date.value)).setHours(0, 0, 0, 0)
    
    if (today <= chosenDate) {
        return false;
    }

    return true;
});

defineExpose({ validate })

</script>
<template>
    <div class="form-group">
        <label :for="id">{{ label }}</label>
        <input type='date' :id="id" v-model="date" class="form-control" />
    </div>
</template>
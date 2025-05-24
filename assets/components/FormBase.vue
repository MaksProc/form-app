<!-- Parent application_form component. Responsible for step switching and rendering -->

<script setup>
import FormStepPagination from './FormStepPagination';
import UserDataStep from './form_steps/UserDataStep.vue';
import ContactDataStep from './form_steps/ContactDataStep.vue';
import ExperienceDataStep from './form_steps/ExperienceDataStep.vue';
import { ref } from 'vue';

const userStep = ref(null);
const contactStep = ref(null);
const experienceStep = ref(null);

const steps = ref([
    {index: 0, step: userStep},
    {index: 1, step: contactStep}, 
    {index: 2, step: experienceStep}
]);

const shownStep = ref(0);

function showStep(index) {
    // steps.value.forEach((step) => {
    //     const container = step.step.container;
    //     container.classList.remove('active', 'previous')
    //     if (step.index === index) {
    //         container.classList.add('active');
    //     }
    //     else if (index === step.index - 1) {
    //         container.classList.add('previous');
    //     }
    // })
    if (index >= 0 && index < steps.value.length) {
        shownStep.value = index;
    }
}

function onSubmit(e) {
    const isValid = userStep.value?.validateStep();
    console.log('Valid: ', isValid);
}

const paginator = ref(null);


</script>

<template>
<div class="form-container bg-light p-3 rounded shadow">
    <form @submit.prevent="onSubmit">
        <div id="form-steps-container">
            <UserDataStep ref="userStep" />
            <ContactDataStep ref="contactStep"></ContactDataStep>
            <ExperienceDataStep ref="experienceStep"></ExperienceDataStep>
        </div>
        <div class="bottom-row mt-3">
            <div class="row g-2 flex-column flex-md-row">
                <div class="col">
                    <FormStepPagination ref="paginator"/>
                </div>
                <div class="col text-end">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
</template>
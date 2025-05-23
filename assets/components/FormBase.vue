<!-- Parent application_form component. Responsible for step switching and rendering -->

<script setup>
import FormStepPagination from './FormStepPagination';
import UserDataStep from './form_steps/UserDataStep.vue';
import ContactDataStep from './form_steps/ContactDataStep.vue';
import ExperienceDataStep from './form_steps/ExperienceDataStep.vue';
</script>

<template>
<div class="">
    <div class="">
        <UserDataStep></UserDataStep>
        <ContactDataStep></ContactDataStep>
        <ExperienceDataStep></ExperienceDataStep>
    </div>
    <FormStepPagination></FormStepPagination>
</div>
</template>
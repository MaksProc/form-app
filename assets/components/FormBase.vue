<!-- Parent application_form component. Responsible for step switching and rendering -->

<script setup>
import FormStepPagination from './FormStepPagination';
import UserDataStep from './form_steps/UserDataStep.vue';
import ContactDataStep from './form_steps/ContactDataStep.vue';
import ExperienceDataStep from './form_steps/ExperienceDataStep.vue';
import { ref } from 'vue';
import { useMultistepForm } from './useMultistepForm';

const { steps, activeStepIndex, stepRefs, activateStep, allValid } =
useMultistepForm([
         { component: UserDataStep },
         { component: ContactDataStep },
         { component: ExperienceDataStep }
    ]);

function onSubmit(e) {
    
    console.log('Valid: ', allValid());
}

const paginator = ref(null);

function onPaginatorSelect(index) {
    if (index < 0 || index > (steps.length - 1)) return false;

    activateStep(index);
}

</script>

<template>
<div class="form-container bg-light p-3 rounded shadow">
    <form @submit.prevent="onSubmit">
        <div id="form-steps-container">
            <div
            class="form-step"
            v-for="(step, index) in steps"
            :key="index"
            :class="{
                active: index === activeStepIndex,
                previous: index < activeStepIndex,
                next: index > activeStepIndex
            }"
            >
                <component
                    :is="step.component"
                    :ref="el => stepRefs[index] = el"
                />
            </div>
        </div>
        <div class="bottom-row mt-3">
            <div class="row g-2 flex-column flex-md-row">
                <div class="col">
                    <FormStepPagination ref="paginator" 
                    :steps="steps" :active="activeStepIndex"
                    @selected="(index) => {onPaginatorSelect(index)}" 
                    />
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
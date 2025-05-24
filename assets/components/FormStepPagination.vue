<!-- Powered by Bootstrap pagination. Used to switch steps of the form -->

<script setup>
const props = defineProps({
    steps: {
        type: Array,
        required: true
    },
    active: {
        type: Number,
        required: true
    }
});

const emit = defineEmits(["selected"]);


</script>
<template>
    <nav>
        <!--Notes: add aria to buttons and links-->
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" @click="emit('selected', active - 1)">Prev</a>
            </li>

            <li
            v-for="(step, index) in steps"
            :key="index"
            class="page-item"
            :class="{
                active: index === active
            }"
            @click="emit('selected', index)"
            >
                <a class="page-link">{{ index + 1 }}</a>
            </li>
            
            <li class="page-item">
                <a class="page-link" @click="emit('selected', active + 1)">Prev</a>
            </li>
        </ul>
    </nav>
</template>
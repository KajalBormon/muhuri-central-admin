<template>
    <div class="fv-plugins-message-container">
        <div class="fv-help-block" v-if="errorMessage">{{ errorMessage }}</div>
    </div>
</template>

<script setup>
const props = defineProps({
    errorMessage: String,
});
</script>

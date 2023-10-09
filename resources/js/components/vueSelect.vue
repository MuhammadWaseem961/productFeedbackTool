<template>
    <Field :name="name" v-slot="{ errors }">
        <select class="form-control border-0" @input="$emit('update:modelValue', $event.target.value);" :name="name" :id="id">
            <option v-for="option in options" :value="option.value" :key="option.value">{{ option.label }}</option>
        </select>
        <span v-if="apiError && apiError.length" class="text-danger mt-1">{{ apiError[0].charAt(0).toUpperCase() +
            apiError[0].slice(1) }}</span>

        <ErrorMessage :name="name" v-else-if="errors && errors.length">
            <span class="text-danger mt-1">{{ errors[0].charAt(0).toUpperCase() + errors[0].slice(1) }}</span>
        </ErrorMessage>
    </Field>
</template>

<script>
    import { Field, ErrorMessage, defineRule } from 'vee-validate';
    defineRule('required', val => !!val, 'This field is required');

    export default {
        name: "vue-select",
        emits: ['update:modelValue'],
        props: {
            
            apiError: Array,
            options: Array,
            name: String,
            id: String,
            value: String,

        },
        methods: {
            
        },
        components: {
            Field,
            ErrorMessage,
        },
    };
</script>

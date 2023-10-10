<template>
    <Field :name="name" :validateOnBlur="true" v-slot="{ errors }">

        <textarea :name="name" class="form-control border-0" rows="3" :placeholder="placeholder" :id="id" @input="$emit('update:modelValue', $event.target.value);"></textarea>

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
        name: "vue-textarea",
        emits: ['update:modelValue'],
        props: {
            apiError: Array,
            name: String,
            id: String,
            value: String,
            placeholder: String,
        },
        methods: {
            
        },
        components: {
            Field,
            ErrorMessage,
        },
    };
</script>

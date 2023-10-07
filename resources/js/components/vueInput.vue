<template>
    <Field :name="name" :validateOnBlur="true" v-slot="{ errors }">
        <input :type="type" class="form-control border-0" :class="getClasses(size, valid)" :name="name" :id="id"
            :placeholder="placeholder" @input="$emit('update:modelValue', $event.target.value);" />

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
        name: "vue-input",
        emits: ['update:modelValue'],
        props: {
            size: {
                type: String,
                default: "default",
            },
            valid: {
                type: Boolean,
                default: false,
            },
            apiError: Array,
            icon: String,
            iconDir: String,
            name: String,
            id: String,
            value: String,
            placeholder: String,
            type: String,
            isRequired: Boolean,

        },
        methods: {
            getClasses: (size, valid) => {
                let sizeValue, isValidValue;

                sizeValue = size ? `form-control-${size}` : null;

                isValidValue = valid ? `${valid}` : "invalid";

                return `${sizeValue} ${isValidValue}`;
            },
            getIcon: (icon) => (icon ? icon : null),
            hasIcon: (icon) => (icon ? "input-group" : null),
        },
        components: {
            Field,
            ErrorMessage,
        },
    };
</script>

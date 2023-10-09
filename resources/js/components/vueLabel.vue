<template>
    <label :for="target" :class="class">{{text}}</label>

</template>

<script>
    export default {
        name: "vue-label",
        props: {
            target: String,
            class: String,
            text: String,

        },
    };
</script>

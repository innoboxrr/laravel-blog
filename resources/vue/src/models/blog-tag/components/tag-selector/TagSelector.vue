<template>
    <div>
        <tags-input-component 
            :custom-class="inputClass"
            :name="__blog('tags')"
            :placeholder="__blog('Add tags')"
            v-model="tags" />
    </div>
</template>

<script>
    import { TagsInputComponent } from 'innoboxrr-form-elements'
    export default {
        components: {
            TagsInputComponent,
        },
        props: {

            preselectedTags: {
                type: [Array, String],
            }
        },
        emits: ['onChangeTags'],
        data() {
            return {
                tags: (this.preselectedTags) ? (Array.isArray(this.preselectedTags) ? this.preselectedTags : this.preselectedTags.split(',')) : [],
            }
        },
        watch: {
            tags: {
                handler: function (value) {
                    this.$emit('onChangeTags', value);
                },
                deep: true,
            }
        },
    }
</script>
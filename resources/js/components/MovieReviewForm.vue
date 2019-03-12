<template>
    <div class="movieReviewSection">
        <form @submit.prevent="submit" method="post"
              :action="predictUrl">
            <transition name="fade">
                <div v-cloak v-show="showError" class="alert alert-danger alert-dismissible">
                    <button v-on:click="closeAlert" type="button" class="close" aria-label="Close">
                        <span v-on:click="closeAlert" aria-hidden="true">&times;</span>
                    </button>
                    {{ error }}
                </div>
            </transition>
            <div v-bind:class="{ 'has-error': errors.has('review') }" class="form-group">
                <label class="control-label" for="review">Movie Review</label>
                <transition name="fade">
                    <label v-cloak class="error text-danger control-label"
                           v-show="errors.has('review')">{{ errors.first('review') }}</label>
                </transition>
                <transition name="fade">
                    <label v-cloak class="results control-label" v-show="showThinking">Hmmm let me give me a second to
                        think...</label>
                </transition>
                <textarea id="review" v-validate="'required|min:15'" data-vv-delay="500" v-model="review" name="review"
                          class="form-control"
                          rows="10"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <div id="results-modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
                 aria-labelledby="mySmallModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-body results">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            The review is <strong>{{ semanticLabel }}</strong>,
                            I'm <strong>{{ probability }}%</strong>
                            sure.
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('Movie Review Form component mounted.')
        },
        props: ['predictUrl'],
        data: function () {
            return {
                review: '',
                semanticLabel: '',
                probability: null,
                error: null,
                showError: null,
                showThinking: false,
                showResults: false
            }
        },
        methods: {
            submit: function (event) {
                // stop displaying the error if one is being shown
                this.showError = false;

                // validate everything to make sure we are clear to submit
                this.$validator.validateAll().then(result => {
                    if (result) {
                        // show our thinking message
                        this.showThinking = true;

                        // getting our form using let for local scope
                        let form = $(event.target);

                        // post the form using an axios ajax post request
                        axios.post(
                            form.attr('action'),
                            form.serialize()
                        ).then(function (response) {
                            // we've got a successful response from the server
                            // lets get our label and probability and assign it to vue
                            this.semanticLabel = response.data.label;
                            this.probability = response.data.probability;

                            // we no longer need to show our thinking message
                            this.showThinking = false;

                            // show the results modal
                            $('#results-modal').modal('show');
                        }.bind(this)).catch(function (error) {
                            if (error.response) {
                                // we have validation errors
                                this.showThinking = false;
                                if (error.response.data.error) {
                                    this.error = error.response.data.error;
                                    this.showError = true;
                                }
                                console.log(error.response.data);
                            } else if (error.request) {
                                // The request was made but no response was received
                                // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                                // http.ClientRequest in node.js
                                console.log(error.request);
                            } else {
                                // Something happened in setting up the request that triggered an Error
                                console.log('Error', error.message);
                            }
                            console.log(error.config);
                        }.bind(this));
                    }
                });
            },
            closeAlert: function () {
                // dont show the error anymore it has been closed
                this.showError = false;
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../sass/variables';

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }

    .fade-enter, .fade-leave-to {
        opacity: 0
    }

    div.form-group {
        label.results, label.error {
            float: right;
        }
    }

    .results {
        font-family: $font-family-robot;
    }
</style>

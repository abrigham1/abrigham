<script>
    export default {
        mounted() {
            console.log('Movie Review Form component mounted.')
        },
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
                this.$validator.validateAll().then(() => {}).catch(() => {});

                // if there are errors we cant submit back to the drawing board
                if (this.errors.any()) {
                    return;
                }

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

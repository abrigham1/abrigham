{{-- we're doing this as an inline template because we need access to our route() helper function --}}
<movie-review-form inline-template>
    <div class="movieReviewSection">
        <form v-on:submit.prevent="submit" method="post"
              action="{{ route('predict-review') }}">
            <transition name="fade">
                <div v-cloak v-show="showError" class="alert alert-danger alert-dismissible">
                    <button v-on:click="closeAlert" type="button" class="close" aria-label="Close">
                        <span v-on:click="closeAlert" aria-hidden="true">&times;</span>
                    </button>
                    @{{ error }}
                </div>
            </transition>
            {{ csrf_field() }}
            <div v-bind:class="{ 'has-error': errors.has('review') }" class="form-group">
                <label class="control-label" for="movieReviewTextarea">Movie Review</label>
                <transition name="fade">
                    <label v-cloak class="error control-label"
                           v-show="errors.has('review')">@{{ errors.first('review') }}</label>
                </transition>
                <transition name="fade">
                    <label v-cloak class="results control-label" v-show="showThinking">Hmmm let me give me a second to
                        think...</label>
                </transition>
                <textarea id="review" v-validate="'required|min:15'" data-vv-delay="500" v-model="review" name="review"
                          class="form-control"
                          rows="10"></textarea>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
            <div id="results-modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
                 aria-labelledby="mySmallModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            The review is <strong>@{{ semanticLabel }}</strong>,
                            I'm <strong>@{{ probability }}%</strong>
                            sure.
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</movie-review-form>
<movie-review-form inline-template>
    <form method="post" action="{{ route('home') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="movieReviewTextarea">Movie Review</label>
            <textarea name="review" id="movieReviewTextarea" class="form-control" rows="10"></textarea>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
</movie-review-form>
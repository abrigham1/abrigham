<template>
    <form>
        <div class="form-group">
            <label for="movieReviewTextarea">Movie Review</label>
            <textarea id="movieReviewTextarea" class="form-control" rows="10"></textarea>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
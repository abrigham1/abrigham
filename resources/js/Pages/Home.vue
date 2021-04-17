<template>
  <MainLayout>
    <template #content-heading>
      Machine Learning with Scikit Learn
    </template>
    <template #main-content>
      <div class="p-1">
        This is a quick demo of one of the cool things you can do with <a target="_blank"
                                                                          href="http://scikit-learn.org">scikit
        learn</a>,
        an open source machine learning library for Python.
        Using the <a target="_blank" href="http://ai.stanford.edu/~amaas/data/sentiment/">IMDB review dataset</a> we are
        training
        a logistic regression model to predict if movie reviews are positive or negative.
        It is based on tutorials from <a target="_blank" href="http://a.co/f2x2HuT">Python Machine Learning</a>
        by Sebastian Raschka which I recommend to anyone looking to learn more.
      </div>
      <div class="p-1">
        To start please write a movie review and then click submit.
      </div>
      <MovieReviewForm :predictUrl="predictUrl" />
    </template>
  </MainLayout>
</template>

<script>
import MainLayout from '@/Layouts/Main'
import MovieReviewForm from "@/Components/MovieReviewForm";

export default {
  props: {
    predictUrl: String
  },
  components: {
    MainLayout,
    MovieReviewForm
  },
}
</script>

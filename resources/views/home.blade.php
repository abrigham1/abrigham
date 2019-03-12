@extends('layouts.master')

@section('title', 'ABrigham - Semantic analysis for movie reviews using scikit learn')

@section('content')
    <h1>Machine Learning with Scikit Learn</h1>
    <p>
        This is a quick demo of one of the cool things you can do with <a target="_blank" href="http://scikit-learn.org">scikit learn</a>,
        an open source machine learning library for Python.
        Using the <a target="_blank" href="http://ai.stanford.edu/~amaas/data/sentiment/">IMDB review dataset</a> we are training
        a logistic regression model to predict if movie reviews are positive or negative.
        It is based on tutorials from <a target="_blank" href="http://a.co/f2x2HuT">Python Machine Learning</a>
        by Sebastian Raschka which I recommend to anyone looking to learn more.
    </p>
    <p>
        To start please write a movie review and then click submit.
    </p>
    <movie-review-form predict-url="{{ Config::get('app.python_api_url') . '/predict' }}">
    </movie-review-form>
@endsection
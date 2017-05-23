import pandas as pd
from sklearn.model_selection import GridSearchCV
from sklearn.pipeline import Pipeline
from sklearn.linear_model import LogisticRegression
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.externals import joblib
from pprint import pprint
from time import time
import os
from MovieReviewClassifierHelpers import preprocessor, tokenizer

# initialize our TfidfVectorizer
tfidf = TfidfVectorizer(strip_accents=None,
                        lowercase=False)

# initialize our logistic regression classifier
lr = LogisticRegression(random_state=0)

# set up our param grid for so we can tune our hyperparameters
# (specifically here we are tuning ngram_range, penalty, and C)
param_grid = {'vect__ngram_range': [(1, 1), (2, 2)],
              'vect__preprocessor': [preprocessor],
              'vect__stop_words': ['english'],
              'vect__tokenizer': [tokenizer],
              'clf__penalty': ['l1', 'l2'],
              'clf__C': [1.0, 10.0, 100.0]
              }

# initialize our pipeline with our vectorizer and our classifier
pipe = Pipeline([('vect', tfidf),
                 ('clf', lr)])

# read our training data into the dataframe
df = pd.read_csv(os.path.join(os.path.dirname(os.path.realpath(__file__)), 'movie_data.csv'))

# get our training data
X_train = df.loc[:25000, 'review'].values
y_train = df.loc[:25000, 'sentiment'].values
X_test = df.loc[25000:, 'review'].values
y_test = df.loc[25000:, 'sentiment'].values

# multiprocessing requires the fork to happen in a __main__ protected block
if __name__ == "__main__":
    # set up our grid search to find our best hyperparameters
    gridsearch = GridSearchCV(pipe, param_grid,
                              scoring='accuracy',
                              cv=3, verbose=1,
                              n_jobs=-1)

    print("Performing grid search...")
    print("pipeline:", [name for name, _ in pipe.steps])
    print("parameters:")
    pprint(param_grid)
    t0 = time()

    # train our classifier
    gridsearch.fit(X_train, y_train)

    print("done in %0.3fs" % (time() - t0))
    print()

    print("Best score: %s" % '{:.1%}'.format(gridsearch.best_score_))
    print("Best parameters set:")
    best_parameters = gridsearch.best_estimator_.get_params()
    for param_name in sorted(param_grid.keys()):
        print("\t%s: %r" % (param_name, best_parameters[param_name]))

    # sanity check to see our best estimator also performs well on our test set
    score = gridsearch.best_estimator_.score(X_test, y_test)
    print('Test Accuracy: %s' % '{:.1%}'.format(score))

    # save our best classifier
    joblib.dump(gridsearch.best_estimator_, 'lr_pipeline.pkl')

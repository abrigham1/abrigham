from sklearn.externals import joblib
import argparse
import os
from MovieReviewClassifierHelpers import preprocessor, tokenizer

# set up our arguments and command line help via argparse
parser = argparse.ArgumentParser(description='Machine Learning Algorithm for semantic analysis of Movie Reviews')
parser.add_argument('review', type=str, help='The movie review text')

# get our command line arguments
args = parser.parse_args()


# load our classifier with joblib
lr_classifier = joblib.load(os.path.join(os.path.dirname(os.path.realpath(__file__)), 'lr_pipeline.pkl'))

# set up our outcome labels
label = {0: 'negative', 1: 'positive'}

# print out the predicted label as well as the probability of said label separated by a comma
print(label[lr_classifier.predict([args.review])[0]] + ',' +
      str(round(lr_classifier.predict_proba([args.review]).max() * 100, 2)))

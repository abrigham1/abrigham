from sklearn.externals import joblib
from flask import Flask, request, jsonify
from flask_cors import CORS
import os
from MovieReviewClassifierHelpers import preprocessor, tokenizer

app = Flask(__name__)
CORS(app)

@app.route('/predict', methods=['POST'])
def predict():
    if request.method == 'POST':
        # get our review from the request
        review = request.form.get('review')
        if review is None:
            return jsonify({"error": "Please enter a review"}), 422

        # load our classifier with joblib
        lr_classifier = joblib.load(os.path.join(os.path.dirname(os.path.realpath(__file__)), 'lr_pipeline.pkl'))

        # set up our outcome labels
        label = {0: 'negative', 1: 'positive'}

        # get our results
        result = {
            "label": label[lr_classifier.predict([review])[0]],
            "probability": str(round(lr_classifier.predict_proba([review]).max() * 100, 2))
        }
        # return as json
        return jsonify(result), 200

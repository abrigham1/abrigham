import re


# Define our preprocessor function which will strip html elements
# normalize emoticons, remove non alpha-numeric characters,
# and lowercase everything
def preprocessor(text):
    # strip html elements
    text = re.sub('<[^>]*>', '', text)

    # pull out all emoticons
    emoticons = re.findall('(?::|;|=)(?:-)?(?:\)|\(|D|P)', text)

    # text to lower get rid of non words and add normalized (no - nose character) back in
    text = re.sub('[\W]+', ' ', text.lower()) + \
           ' '.join(emoticons).replace('-', '')
    return text


# Define our tokenizer function which will split our words on whitespace (space, tab, newline, return, formfeed)
def tokenizer(text):
    # split everything into a tokenized array
    return [w for w in text.split()]

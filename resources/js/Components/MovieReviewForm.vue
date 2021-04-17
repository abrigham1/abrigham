<template>
  <div class="movieReviewSection">
    <Form @submit="submit" :validation-schema="validationSchema">
      <div class="my-2 relative rounded-md shadow-sm">
        <label for="review" class="sr-only">Review</label>
        <Field name="review" v-slot="{field, errorMessage}">
          <textarea id="review" v-bind="field" rows="10" :class="errorMessage? errorInputClass : defaultInputClass"
                    :aria-invalid="!!errorMessage"
                    :aria-describedby="errorMessage ? 'review-error' : ''"/>
        </Field>
      </div>
      <ErrorMessage id="review-error" name="review" as="p" class="mt-2 text-sm text-red-600"/>
      <button id="submit-review" type="submit"
              class="my-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Submit
      </button>
      <Modal :isOpen="showResults" :close="closeModal">
        <p id="results-error" v-if="showError">
          {{ error }}
        </p>
        <p id="results" v-if="!showError && showResults">
          The review is {{ semanticLabel }}, I'm {{ probability }}% sure.
        </p>
      </Modal>
    </Form>
  </div>
</template>

<script>
import {Form, Field, ErrorMessage} from 'vee-validate';
import {object as yupObject, string as yupString} from 'yup';
import {markRaw} from 'vue';
import Modal from '@/Components/Modal'

export default {
  components: {
    Modal,
    Form,
    Field,
    ErrorMessage,
  },
  props: {
    predictUrl: String
  },
  data() {
    const validationSchema = markRaw(yupObject({
      review: yupString().required().min(15).label('Review'),
    }));
    return {
      semanticLabel: '',
      probability: null,
      error: '',
      showError: null,
      showThinking: false,
      showResults: false,
      validationSchema: validationSchema,
      defaultInputClass: 'shadow-sm block w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md',
      errorInputClass: 'block w-full pr-10 border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md',
    }
  },
  methods: {
    /**
     * Close the modal
     *
     **/
    closeModal() {
      this.showResults = false;
    },
    /**
     * Submit the movie review form
     *
     * @param values
     */
    submit(values) {
      // show our thinking message
      this.showThinking = true;
      // getting our form using let for local scope
      // post the form using an axios ajax post request
      let data = new FormData();
      data.append('review', values.review);
      axios.post(
          this.predictUrl,
          data
      ).then(response => {
        // we've got a successful response from the server
        // lets get our label and probability and assign it to vue
        this.semanticLabel = response.data.label;
        this.probability = response.data.probability;

        // we no longer need to show our thinking message
        this.showThinking = false;
        // show the results modal
        this.showResults = true;
      }).catch(error => {
        if (error.response) {
          // we have validation errors
          this.showThinking = false;
          this.showResults = true;
          if (error.response.data.error) {
            this.error = error.response.data.error;
            this.showError = true;
          }
        } else if (error.request) {
          // The request was made but no response was received
          // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
          // http.ClientRequest in node.js
        } else {
          // Something happened in setting up the request that triggered an Error
        }
      });
    }
  }
}
</script>

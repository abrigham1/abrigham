import {createLocalVue, mount} from '@vue/test-utils';
import MovieReviewForm from '../../resources/js/components/MovieReviewForm';
let VeeValidate = require('vee-validate');

const localVue = createLocalVue();
localVue.use(VeeValidate);

describe('MovieReviewForm', () => {
    it('renders the textarea and hides the modal on load', () => {
        let wrapper = mount(MovieReviewForm, {localVue});

        expect(wrapper.find('#review').isVisible()).toBe(true);
        expect(wrapper.find('#results-modal.show').exists()).toBe(false);
    });
});
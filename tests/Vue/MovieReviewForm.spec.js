import {createLocalVue, shallowMount} from '@vue/test-utils';
import MovieReviewForm from '../../resources/js/components/MovieReviewForm';
import flushPromises from 'flush-promises';
let VeeValidate = require('vee-validate');

const localVue = createLocalVue();
localVue.use(VeeValidate);

describe('MovieReviewForm', () => {
    it('renders the textarea and hides the modal on load', () => {
        let wrapper = shallowMount(MovieReviewForm, {localVue});

        expect(wrapper.find('#review').isVisible()).toBe(true);
        expect(wrapper.find('#results-modal.show').exists()).toBe(false);
    });

    // vee-validate doesn't play well with vue test utils yet
    // https://github.com/baianat/vee-validate/issues/965
    /*it('displays an error on submission of an empty review', async () => {
        let wrapper = shallowMount(MovieReviewForm, {localVue, sync: false});
        // wait till everything loads after mounting
        await flushPromises();
        // get our submit review button and click it
        wrapper.find('#submit-review').trigger('click');
        // wait for everything to flush
        await flushPromises();
        // make our assertions
        expect(wrapper.vm.$validator.errors.first('review')).toEqual('The review field is required');
        expect(wrapper.text()).toContain('The review field is required');
    });*/
});
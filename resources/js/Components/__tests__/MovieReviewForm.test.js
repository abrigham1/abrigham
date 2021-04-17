import {render, screen} from '@testing-library/vue'
import userEvent from "@testing-library/user-event";
import MovieReviewForm from "@/Components/MovieReviewForm";
import {flushPromises} from "@vue/test-utils";
import MockAdapter from "axios-mock-adapter";

let mockAxios;

describe('MovieReviewForm', () => {
    beforeEach(() => {
        mockAxios = new MockAdapter(axios);
    });

    afterEach(() => {
        mockAxios.restore();
        mockAxios.reset();
    });
    test('it validates when there is no input', async () => {
        const {getByLabelText, getByText, queryByText} = render(MovieReviewForm);

        getByLabelText(/review/i);
        const submit = getByText(/submit/i);

        // no error should appear until we click submit
        expect(queryByText('Review is a required field')).toBeFalsy();
        expect(queryByText('Review must be at least 15 characters')).toBeFalsy();

        userEvent.click(submit);
        await flushPromises();

        getByText('Review is a required field')
    });

    test('it validates when input is too short', async () => {
        const {getByLabelText, getByText, queryByText} = render(MovieReviewForm);

        const review = getByLabelText(/review/i);
        const submit = getByText(/submit/i);

        // no error should appear until we click submit
        expect(queryByText('Review is a required field')).toBeFalsy();
        expect(queryByText('Review must be at least 15 characters')).toBeFalsy();

        userEvent.type(review, 'Hello World!');
        userEvent.click(submit);
        await flushPromises();

        getByText('Review must be at least 15 characters')
    });

    test('it displays results when input is good', async () => {
        const predictUrl = 'https://jest-test.com/predict';
        const props = {predictUrl: predictUrl};
        const mockResponse = {label: "positive", probability: "95"};
        const mockReview = 'This is a test to see if it works with a long enough text.';

        const {getByLabelText, getByText, queryByText} = render(MovieReviewForm, {props});

        const review = getByLabelText(/review/i);
        const submit = getByText(/submit/i);

        // no error should appear until we click submit
        expect(queryByText('Review is a required field')).toBeFalsy();
        expect(queryByText('Review must be at least 15 characters')).toBeFalsy();

        mockAxios.onPost(predictUrl).reply(200, mockResponse);

        // fill in the review and submit it
        userEvent.type(review, mockReview);
        userEvent.click(submit);
        await flushPromises();

        // no error after submission
        expect(queryByText('Review is a required field')).toBeFalsy();
        expect(queryByText('Review must be at least 15 characters')).toBeFalsy();
        // should see our review
        getByText("The review is positive, I'm 95% sure.");
    });

    test('it handles an error response from the api endpoint', async () => {
        const predictUrl = 'https://jest-test.com/predict';
        const props = {predictUrl: predictUrl};
        const mockResponse = {error: 'Sorry please try again later.'};
        const mockReview = 'This is a test to see if it works with a long enough text.';

        const {getByLabelText, getByText, queryByText} = render(MovieReviewForm, {props});

        const review = getByLabelText(/review/i);
        const submit = getByText(/submit/i);

        // no error should appear until we click submit
        expect(queryByText('Review is a required field')).toBeFalsy();
        expect(queryByText('Review must be at least 15 characters')).toBeFalsy();

        mockAxios.onPost(predictUrl).reply(422, mockResponse);

        // fill in the review and submit it
        userEvent.type(review, mockReview);
        userEvent.click(submit);
        await flushPromises();

        // no js errors on the page we actually submitted to the endpoint
        expect(queryByText('Review is a required field')).toBeFalsy();
        expect(queryByText('Review must be at least 15 characters')).toBeFalsy();

        // error from api is displayed to the user
        getByText("Sorry please try again later.");
    });
})
;

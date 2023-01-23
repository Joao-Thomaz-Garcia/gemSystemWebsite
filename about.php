<?php 
if(!isset($_SESSION)){
    session_start();
  }
?>
<?php include("nav.php")?>

<link rel="stylesheet" href="./css/about.css">

<header>
<section class="faqs">
    <h2>OUR FREQUENT QUESTIONS ANSWERED</h2>
    <div class="container faqs__container">
        <article class="faq">
            <div class="faq__icon"><i class="uil uil-plus"></i></div>
            <div class="question__answer">
                <h4>What is needed to rent a car?</h4>
                <p>You must possess and present a valid Driver’s License and be at least 21 years old of age. In addition, present a nominal credit card for the pre-authorization operation. Prepaid or virtual cards will not be accepted for this operation
                </p>
            </div>
        </article>

        <article class="faq">
            <div class="faq__icon"><i class="uil uil-plus"></i></div>
            <div class="question__answer">
                <h4>What payment methods are available for renting a car?</h4>
                <p>We accept two types of payment:

* Debit or credit card in the name of the renter
                </p>
            </div>
        </article>

        <article class="faq">
            <div class="faq__icon"><i class="uil uil-plus"></i></div>
            <div class="question__answer">
                <h4>Is it possible to pay for the car rental through the website?</h4>
                <p>Yes, it is possible.
                </p>
            </div>
        </article>

        <article class="faq">
            <div class="faq__icon"><i class="uil uil-plus"></i></div>
            <div class="question__answer">
                <h4>Can I add a driver?</h4>
                <p>Yes, you can add a new driver containing all the requirements that is required by GEM for rental
                </p>
            </div>
        </article>

        <article class="faq">
            <div class="faq__icon"><i class="uil uil-plus"></i></div>
            <div class="question__answer">
                <h4>How do i make sure my vehicle is reserved?</h4>
                <p>You will receive a confirmation email as soon as you are done reserving on our website.
                </p>
            </div>
        </article>

        <article class="faq">
            <div class="faq__icon"><i class="uil uil-plus"></i></div>
            <div class="question__answer">
                <h4>I was involved in a traffic accident or had my car stolen/stolen. How do I make a claim?</h4>
                <p>You must visit RentalCover.com/claim to start your claim.
Provide a detailed description of the event.
For all claims, we require, as a minimum, a detailed description of the event. We may request documents during the claim process such as booking invoices and receipts. If these documents are not provided to us the claim may be rejected or the status changed to “Pending” until we receive the required documents.

Once we have the required documents your claim will be handled by our insurer’s liability claim specialists.
                </p>
            </div>
        </article>

        <article class="faq">
            <div class="faq__icon"><i class="uil uil-plus"></i></div>
            <div class="question__answer">
                <h4>In case of a traffic fine, how to proceed?</h4>
                <p>Notify GEM immediately via message or email.
                </p>
            </div>
        </article>

        <article class="faq">
            <div class="faq__icon"><i class="uil uil-plus"></i></div>
            <div class="question__answer">
                <h4>My car stopped working. What should I do?</h4>
                <p>Contacting insurance directly and later with GEM.
                </p>
            </div>
        </article>

        <article class="faq">
            <div class="faq__icon"><i class="uil uil-plus"></i></div>
            <div class="question__answer">
                <h4>How should I proceed with fuel?</h4>
                <p>Deliver the fuel at the same level the car was taken from.
                </p>
            </div>
        </article>
        </header>
<!--        <article class="faq">
            <div class="faq__icon"><i class="uil uil-plus"></i></div>
            <div class="question__answer">
                <h4>How do I Know the right courses for me?</h4>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit possimus,
                     voluptatum cum cupiditate aut quis nostrum! 
                     Quo, magnam, ad consequuntur maxime optio vel enim voluptas molestias doloremque,
                      est repellat dolores!
                </p>
            </div>
        </article>
-->
        <script type="text/javascript">
const faqs = document.querySelectorAll('.faq');

faqs.forEach(faq => {
    faq.addEventListener('click', () => {
        faq.classList.toggle('open');
   

const icon = faq.querySelector('.faq__icon i');
if(icon. className === 'uil uil-plus ') {
    icon.className = "uil uil-minus";
} else {
    icon.className = "uil uil-plus";
}
})
})

        </script>
     
    </div>
</section>
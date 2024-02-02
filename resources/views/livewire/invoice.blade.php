<div>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand header_brand_heading" href="{{ url('/') }}">INTELLI-RATE</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                    aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('interesting_stories') }}">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('view_feedback') }}">Feedback</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        @if (Auth::check())
                        <button onclick="window.location.href='/home'" class="btn submit_btn">Go To
                            Dashboard</button>
                        <button class="btn btn-danger mx-4">
                            <a href="{{ route('logout') }}" style="text-decoration: none; !important; color:white;"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </button>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        @else
                        <button onclick="window.location.href='/signup'" class="btn signUp_btn me-2">Sign Up Now</button>
                        <button onclick="window.location.href='/signin'" class="btn submit_btn">Login</button>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <section class="back_sign__ py-3">
        <div class="container-fluid">
            <div class="col-md-8  m-auto">
                <h2 class="mb-5 text-center">Intelli-Rate</h2>
                <div class="main_signUp">
                    <div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class=" border border-3 border-dark p-3">
                                @include('reports.invoice',compact('reports','bank','user'))
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="mb-3 text-center">
                                <button type="submit"
                                    class="btn submit_btn" wire:click="download">Download Invoice</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="bank_select_divv" style="height: 300px">
                                <h2 class="text-center"> Terms & Conditions</h2>
                                <p>
                                    BancAnalytics Corporation (“BancAnalytics,” “we,” “us,” “our”) provides
                                    its services (described below) through its website
                                    <a href="www.intelli-rate.com">www.intelli-rate.com</a> (the “Site”) and
                                    are subject to the following Terms of Service (as amended from time to
                                    time, the “Terms of Service”). We reserve the right, at our sole
                                    discretion, to change or modify portions of these Terms of Service at any
                                    time. If we do this, we will post the changes on this page and will
                                    indicate at the top of this page the date these terms were last revised.
                                    We will also notify you, either in an email notification or through other
                                    reasonable means. Any such changes will become effective no earlier than
                                    fourteen (14) days after they are posted, except that changes addressing
                                    new functions of the Services or changes made for legal reasons will be
                                    effective immediately. Your continued use of the Services after the date
                                    any such changes become effective constitutes your acceptance of the new
                                    Terms of Service.
                                  </p>
                                  <br />

                                  <strong>
                                    <i>
                                      PLEASE READ THESE TERMS OF SERVICE CAREFULLY, AS THEY CONTAIN AN
                                      AGREEMENT TO ARBITRATE AND OTHER IMPORTANT INFORMATION REGARDING YOUR
                                      LEGAL RIGHTS, REMEDIES, AND OBLIGATIONS. THE AGREEMENT TO ARBITRATE
                                      REQUIRES (WITH LIMITED EXCEPTION) THAT YOU SUBMIT CLAIMS YOU HAVE
                                      AGAINST US TO BINDING AND FINAL ARBITRATION, AND FURTHER (1) YOU WILL
                                      ONLY BE PERMITTED TO PURSUE CLAIMS AGAINST BANCANALYTICS ON AN
                                      INDIVIDUAL BASIS, NOT AS A PLAINTIFF OR CLASS MEMBER IN ANY CLASS OR
                                      REPRESENTATIVE ACTION OR PROCEEDING, AND (2) YOU WILL ONLY BE PERMITTED
                                      TO SEEK RELIEF (INCLUDING MONETARY, INJUNCTIVE, AND DECLARATORY RELIEF)
                                      ON AN INDIVIDUAL BASIS.
                                    </i>
                                  </strong>

                                  <br />

                                  <h3>Access and Use of the Services</h3>

                                  <p>
                                    <strong>Services Description: </strong>
                                    The Services provided by us will allow clients to access deposit rate
                                    yield data through the Site for market surveys select metropolitan areas
                                    and/or for custom surveys for which the client has ordered and paid for in
                                    advance. The Site will allow the client to download the weekly report in
                                    pdf form. Users must be current employees of a financial institution and
                                    have valid email addresses from the institution’s website.
                                  </p>

                                  <p>
                                    <strong>Registration and Eligibility: </strong>
                                    You are required to register with BancAnalytics to access and use the
                                    Site. You are eligible to register for the Services only in your capacity
                                    as an authorized agent of the financial institution. If you choose to
                                    register for the Services, you agree to provide and maintain true,
                                    accurate, current and complete information about yourself as prompted by
                                    the Services’ registration form.
                                  </p>

                                  <p>
                                    <strong>Member Account, Password and Security: </strong>
                                    You are responsible for maintaining the confidentiality of your password
                                    and account, if any, and are fully responsible for any and all activities
                                    that occur under your password or account. Your account belongs to you
                                    only, and you may not share your account with any other individual(s). You
                                    agree to immediately notify BancAnalytics of any unauthorized use of your
                                    password or account or any other breach of security.
                                  </p>

                                  <p>
                                    <strong>Modifications to Services: </strong>
                                    BancAnalytics reserves the right to modify or discontinue, temporarily or
                                    permanently, the Services (or any part thereof) with or without notice.
                                    You agree that BancAnalytics will not be liable to you or to any third
                                    party for any modification, suspension or discontinuance of the Services.
                                  </p>

                                  <p>
                                    <strong>General Practices Regarding Use and Storage: </strong>
                                    You acknowledge that BancAnalytics may establish general practices and
                                    limits concerning use of the Services, including without limitation the
                                    maximum period of time that data or other content will be retained by the
                                    Services and the maximum storage space that will be allotted on
                                    BancAnalytics’ servers on your behalf. You agree that BancAnalytics has no
                                    responsibility or liability for the deletion or failure to store any data
                                    or other content maintained or uploaded by the Services. You acknowledge
                                    that BancAnalytics reserves the right to terminate your account if you do
                                    not comply with these Terms of Service or other limits we may set from
                                    time to time regarding the use of the Services. You further acknowledge
                                    that BancAnalytics reserves the right to change these general practices
                                    and limits at any time, in its sole discretion, with or without notice.
                                  </p>

                                  <p>
                                    <strong>Invoicing and Payment: </strong>
                                    BancAnalytics will invoice you for an annual subscription. Upon payment of
                                    the invoiced amount to BancAnalytics you will be granted access to our
                                    Services for the data that you purchased for a period of one year.
                                  </p>

                                  <p>
                                    <strong>Violation of Terms: </strong>
                                    If we determine in our sole discretion that you have violated the Terms of
                                    Service, we may in our sole discretion and as permitted by law terminate
                                    your account with no refund.
                                  </p>

                                  <h3>Conditions of Use</h3>

                                  <p>
                                    <strong>User Conduct: </strong>
                                    You are solely responsible for all code, video, images, information, data,
                                    text, software, music, sound, photographs, graphics, messages, or other
                                    materials (“content”) that you upload, post, publish or display
                                    (hereinafter, “upload”) or email or otherwise use via the Services or the
                                    internet. The following are examples of the kind of content and/or use
                                    that is illegal or prohibited by BancAnalytics. We reserve the right to
                                    investigate and take appropriate legal action against anyone who, in our
                                    sole discretion, violates this provision, including without limitation,
                                    removing the offending content from the Services, suspending, or
                                    terminating the account of such violators and reporting you to the law
                                    enforcement authorities. You agree not to:
                                  </p>

                                  <ul>
                                    <li>
                                      email or otherwise upload any content to the Services that (i) infringes
                                      any intellectual property or other proprietary rights of any party; (ii)
                                      you do not have a right to upload under any law or under contractual or
                                      fiduciary relationships; (iii) contains software viruses or any other
                                      computer code, files or programs designed to interrupt, destroy or limit
                                      the functionality of any computer software or hardware or
                                      telecommunications equipment; (iv) poses or creates a privacy or
                                      security risk to any person; (v) constitutes unsolicited or unauthorized
                                      advertising, promotional materials, commercial activities and/or sales,
                                      “junk mail,” “spam,” “chain letters,” “pyramid schemes,” “contests,”
                                      “sweepstakes,” or any other form of solicitation; (vi) is unlawful,
                                      harmful, threatening, abusive, harassing, tortious, excessively violent,
                                      defamatory, vulgar, obscene, pornographic, libelous, invasive of
                                      another’s privacy, hateful racially, ethnically or otherwise
                                      objectionable; or (vii) in the sole judgment of BancAnalytics, is
                                      objectionable or which restricts or inhibits any other person from using
                                      or enjoying the Services, or which may expose its users to any harm or
                                      liability of any type; or
                                    </li>

                                    <li>
                                      interfere with or disrupt the Services or servers or networks connected
                                      to the Services, or disobey any requirements, procedures, policies, or
                                      regulations of networks connected to the Service; or
                                    </li>

                                    <li>
                                      use the Services to violate any applicable local, state, national or
                                      international law, or any regulations having the force of law; or
                                    </li>

                                    <li>
                                      use the Services to impersonate any person or entity, or falsely state
                                      or otherwise misrepresent your affiliation with a person or entity; or
                                    </li>

                                    <li>
                                      impersonate, or falsely state or otherwise misrepresent your affiliation
                                      with BancAnalytics; or
                                    </li>

                                    <li>
                                      share promotional codes for specific classes of users beyond the
                                      intended audience; or
                                    </li>

                                    <li>
                                      violate the terms of our Referral and/or Affiliate Programs, if any; or
                                    </li>

                                    <li>
                                      use the Services to solicit personal information from anyone under the
                                      age of 18; or
                                    </li>

                                    <li>
                                      harvest or collect email addresses or other contact information of other
                                      users from the Services by electronic or other means for the purposes of
                                      sending unsolicited emails or other unsolicited communications; or
                                    </li>

                                    <li>
                                      use the Services to advertise or offer to sell or buy any goods or
                                      services for any business purpose that is not specifically authorized;
                                      or
                                    </li>

                                    <li>
                                      use the Services to further or promote any criminal activity or
                                      enterprise or provide instructional information about illegal
                                      activities; or
                                    </li>

                                    <li>
                                      use the Services to obtain or attempt to access or otherwise obtain any
                                      materials or information through any means not intentionally made
                                      available or provided for through the Service.
                                    </li>
                                  </ul>

                                  <h3>Intellectual Property Rights</h3>

                                  <p>
                                    <strong>Services Content, Software and Trademarks :</strong>
                                    You acknowledge and agree that the Services may contain content or
                                    features (“Services Content”) that are protected by copyright, patent,
                                    trademark, trade secret or other proprietary rights and laws. Except as
                                    expressly authorized by BancAnalytics, you agree not to modify, copy,
                                    frame, scrape, rent, lease, loan, sell, distribute, or create derivative
                                    works based on the Services or the Services Content, in whole or in part.
                                    In connection with your use of the Services you will not engage in or use
                                    any data mining, robots, scraping, or similar data gathering or extraction
                                    methods. If you are blocked by BancAnalytics from accessing the Services
                                    (including by blocking your IP address), you agree not to implement any
                                    measures to circumvent such blocking (e.g., by masking your IP address or
                                    using a proxy IP address). Any use of the Services or the Services Content
                                    other than as specifically authorized herein is strictly prohibited. The
                                    technology and software underlying the Services or distributed in
                                    connection therewith are the property of BancAnalytics, our affiliates and
                                    our partners (the “Software”). You agree not to copy, modify, create a
                                    derivative work of, reverse engineer, reverse assemble or otherwise
                                    attempt to discover any source code, sell, assign, sublicense, or
                                    otherwise transfer any right in the Software. Any rights not expressly
                                    granted herein are reserved by BancAnalytics.
                                    <br />
                                    The BancAnalytics name and logos are trademarks and service marks of
                                    BancAnalytics (collectively the “ Trademarks”).
                                  </p>

                                  <p>
                                    <strong>Third Party Material: </strong>
                                    Under no circumstances will BancAnalytics be liable in any way for any
                                    content or materials of any third parties (including users), including,
                                    but not limited to, for any errors or omissions in any content, or for any
                                    loss or damage of any kind incurred as a result of the use of any such
                                    content. You agree that you must evaluate, and bear all risks associated
                                    with, the use of any content, including any reliance on the accuracy,
                                    completeness, or usefulness of such content.
                                  </p>

                                  <h3>Third Party Websites</h3>

                                  <p>
                                    The Services may provide, or third parties may provide, links or other
                                    access to other sites and resources on the Internet. BancAnalytics has no
                                    control over such sites and resources and BancAnalytics is not responsible
                                    for and does not endorse such sites and resources. You further acknowledge
                                    and agree that BancAnalytics will not be responsible or liable directly,
                                    or indirectly, for any damage or loss caused or alleged to be caused by or
                                    in connection with use of or reliance on any content, events, goods or
                                    services available on or through any such site or resource. Any dealings
                                    you have with third parties found while using the Services are between you
                                    and the third party, and you agree that BancAnalytics is not liable for
                                    any loss or claim that you may have against any such third party.
                                  </p>

                                  <h3>Indemnity and Release</h3>

                                  <p>
                                    You agree to release, indemnify and hold BancAnalytics and its affiliates
                                    and their officers, employees, directors and agents (collectively,
                                    “Indemnitees”) harmless from any and all losses, damages, expenses,
                                    including reasonable attorneys’ fees, rights, claims, actions of any kind
                                    arising out of or relating to your use of the Services, any User Content,
                                    your connection to the Services, your violation of these Terms of Service
                                    or your violation of any rights of another.
                                  </p>

                                  <h3>Disclaimer of Warranties</h3>

                                  <p>
                                    Your use of the Services is at your sole risk. The Services are provided
                                    on an “as is” and “as available” basis. BancAnalytics expressly disclaims
                                    all warranties of any kind, whether express, implied or statutory,
                                    including, but not limited to the implied warranties of merchantability,
                                    fitness for a particular purpose, title and non-infringement.
                                  </p>

                                  <p>
                                    BancAnalytics makes no warranty that (i) the Services will meet your
                                    requirements, (ii) the Services will be uninterrupted, timely, secure, or
                                    error-free, (iii) the results that may be obtained from the use of the
                                    Services will be accurate or reliable, or (iv) the quality of any
                                    products, services, information, or other material purchased or obtained
                                    by you through the Services will meet your expectations.
                                  </p>

                                  <h3>Limitation of Liability</h3>

                                  <p>
                                    You expressly understand and agree that BancAnalytics will not be liable
                                    for any indirect, incidental, special, consequential, exemplary damages,
                                    or damages for loss of profits including but not limited to, damages for
                                    loss of goodwill, use, data or other intangible losses (even if
                                    BancAnalytics has been advised of the possibility of such damages),
                                    whether based on contract, tort, negligence, strict liability or
                                    otherwise, resulting from: (i) the use or the inability to use the
                                    Services; (ii) the cost of procurement of substitute goods and services
                                    resulting from any goods, data, information or services purchased or
                                    obtained or messages received or transactions entered into through or from
                                    the Services; (iii) unauthorized access to or alteration of your
                                    transmissions or data; (iv) statements or conduct of any third party on
                                    the Services; or (v) any other matter relating to the Services. In no
                                    event will BancAnalytics’ total liability to you for all damages, losses
                                    or causes of action exceed the amount you have paid BancAnalytics in the
                                    last twelve (12) months, or, if greater, one hundred dollars ($100).
                                  </p>

                                  <p>
                                    <strong>Dispute Resolution by Binding Arbitration: </strong>
                                    <strong
                                      >PLEASE READ THIS SECTION CAREFULLY AS IT AFFECTS YOUR RIGHTS. TO OPT
                                      OUT OF THIS ARBITRATION AND CLASS ACTION WAIVER AGREEMENT, YOU MUST
                                      WRITE US AT:</strong
                                    >
                                  </p>

                                  <p>
                                    <b>BancAnalytics Corporation.</b><br />
                                    <b>P.O. Box 510385</b><br />
                                    <b>St. Louis, MO 63151 </b>
                                  </p>

                                  <h4>YOU MUST:</h4>
                                  <ul>
                                    <li>
                                      <b>GIVE WRITTEN NOTICE; AND</b>
                                    </li>
                                    <li>
                                      <b>INCLUDE YOUR NAME; AND</b>
                                    </li>
                                    <li>
                                      <b
                                        >STATE THAT YOU REJECT ARBITRATION AND/OR PROHIBITION OF CLASS AND
                                        REPRESENTATIVE ACTION AND NON-INDIVIDUALIZED RELIEF.</b
                                      >
                                    </li>
                                  </ul>

                                  <p>
                                    <strong>
                                      TO BE EFFECTIVE, WE MUST RECEIVE YOUR WRITTEN NOTICE WITHIN THIRTY (30)
                                      DAYS OF THE FIRST DATE YOU REGISTER FOR THE SERVICES.
                                    </strong>
                                  </p>

                                  <p>
                                    <strong>
                                      IF YOU OPT OUT, ANY DISPUTES WILL STILL BE GOVERNED BY THE LAWS OF THE
                                      STATE OF MISSOURI AND APPLICABLE FEDERAL LAW AND MUST BE BROUGHT WITHIN
                                      THE STATE OF MISSOURI’S COURT SYSTEM.
                                    </strong>
                                  </p>

                                  <h3>Agreement to Arbitrate</h3>

                                  <p>
                                    This Dispute Resolution by Binding Arbitration section is referred to in
                                    these Terms of Service as the “Arbitration Agreement.” You agree that any
                                    and all disputes or claims that have arisen or may arise between you and
                                    BancAnalytics, whether arising out of or relating to these Terms of
                                    Service (including any alleged breach thereof), the Services, any
                                    advertising, any aspect of the relationship or transactions between us,
                                    shall be resolved exclusively through final and binding arbitration,
                                    rather than a court, in accordance with the terms of this Arbitration
                                    Agreement, except that you may assert individual claims in small claims
                                    court, if your claims qualify. Further, this Arbitration Agreement does
                                    not preclude you from bringing issues to the attention of federal, state,
                                    or local agencies, and such agencies can, if the law allows, seek relief
                                    against us on your behalf.
                                    <strong
                                      >YOU AGREE THAT, BY ENTERING INTO THESE TERMS OF SERVICE, YOU AND
                                      BANCANALYTICS ARE EACH WAIVING THE RIGHT TO A TRIAL BY JURY OR TO
                                      PARTICIPATE IN A CLASS ACTION. YOUR RIGHTS WILL BE DETERMINED BY A
                                      NEUTRAL ARBITRATOR, NOT A JUDGE OR JURY. </strong
                                    >The Federal Arbitration Act governs the interpretation and enforcement of
                                    this Arbitration Agreement.
                                  </p>
                                  <p>

                                  <strong
                                    >Prohibition of Class and Representative Actions and Non-Individualized
                                    Relief</strong
                                  >
                                  <br><br>

                                    <strong>
                                      YOU AND BANCANALYTICS AGREE THAT EACH OF US MAY BRING CLAIMS AGAINST THE
                                      OTHER ONLY ON AN INDIVIDUAL BASIS AND NOT AS A PLAINTIFF OR CLASS MEMBER
                                      IN ANY PURPORTED CLASS OR REPRESENTATIVE ACTION OR PROCEEDING. UNLESS
                                      BOTH YOU AND BANCANALYTICS AGREE OTHERWISE, THE ARBITRATOR MAY NOT
                                      CONSOLIDATE OR JOIN MORE THAN ONE PERSON’S OR PARTY’S CLAIMS AND MAY NOT
                                      OTHERWISE PRESIDE OVER ANY FORM OF A CONSOLIDATED, REPRESENTATIVE, OR
                                      CLASS PROCEEDING. ALSO, THE ARBITRATOR MAY AWARD RELIEF (INCLUDING
                                      MONETARY, INJUNCTIVE, AND DECLARATORY RELIEF) ONLY IN FAVOR OF THE
                                      INDIVIDUAL PARTY SEEKING RELIEF AND ONLY TO THE EXTENT NECESSARY TO
                                      PROVIDE RELIEF NECESSITATED BY THAT PARTY’S INDIVIDUAL CLAIM(S).
                                    </strong>
                                  </p>

                                  <h3>Pre-Arbitration Dispute Resolution</h3>

                                  <p>
                                    BancAnalytics is always interested in resolving disputes amicably and
                                    efficiently, and most customer concerns can be resolved quickly and to the
                                    customer’s satisfaction by emailing Customer Support at
                                    support@intelli-rate.com. If such efforts prove unsuccessful, a party who
                                    intends to seek arbitration must first send to the other, by certified
                                    mail, a written Notice of Dispute (“Notice”). The Notice to BancAnalytics
                                    should be sent to BancAnalytics Corporation, P.O. Box 510385, St. Louis,
                                    MO 63151 (“Notice Address”). The Notice must (i) describe the nature and
                                    basis of the claim or dispute and (ii) set forth the specific relief
                                    sought. If BancAnalytics and you do not resolve the claim within sixty
                                    (60) calendar days after the Notice is received, you or BancAnalytics may
                                    commence an arbitration proceeding. During the arbitration, the amount of
                                    any settlement offer made by BancAnalytics or you shall not be disclosed
                                    to the arbitrator until after the arbitrator determines the amount, if
                                    any, to which you or BancAnalytics is entitled.
                                  </p>

                                  <h3>Arbitration Procedures</h3>

                                  <p>
                                    Arbitration will be conducted by a neutral arbitrator in accordance with
                                    the American Arbitration Association’s (“AAA”) rules and procedures,
                                    including the AAA’s Supplementary Procedures for Commercial-Related
                                    Disputes (collectively, the “AAA Rules”), as modified by this Arbitration
                                    Agreement. For information on the AAA, please visit its website,
                                    <a href="www.adr.org">www.adr.org</a>.Information about the AAA Rules and
                                    fees for consumer disputes can be found at the AAA’s consumer arbitration
                                    page, <a href=" www.adr.org/Rules"> www.adr.org/Rules</a>. If there is any
                                    inconsistency between any term of the AAA Rules and any term of this
                                    Arbitration Agreement, the applicable terms of this Arbitration Agreement
                                    will control unless the arbitrator determines that the application of the
                                    inconsistent Arbitration Agreement terms would not result in a
                                    fundamentally fair arbitration. The arbitrator must also follow the
                                    provisions of these Terms of Service as a court would. All issues are for
                                    the arbitrator to decide, including, but not limited to, issues relating
                                    to the scope, enforceability, and arbitrability of this Arbitration
                                    Agreement. Although arbitration proceedings are usually simpler and more
                                    streamlined than trials and other judicial proceedings, the arbitrator can
                                    award the same damages and relief on an individual basis that a court can
                                    award to an individual under the Terms of Service and applicable law.
                                    Decisions by the arbitrator are enforceable in court and may be overturned
                                    by a court only for very limited reasons.

                                    <br />

                                    Unless BancAnalytics and you agree otherwise, any arbitration hearings
                                    will take place in a reasonably convenient location for both parties with
                                    due consideration of their ability to travel and other pertinent
                                    circumstances. If the parties are unable to agree on a location, the
                                    determination shall be made by AAA. If your claim is for $10,000 or less,
                                    BancAnalytics agrees that you may choose whether the arbitration will be
                                    conducted solely based on documents submitted to the arbitrator, through a
                                    telephonic hearing, or by an in-person hearing as established by the AAA
                                    Rules. If your claim exceeds $10,000, the right to a hearing will be
                                    determined by the AAA Rules. Regardless of the way the arbitration is
                                    conducted, the arbitrator shall issue a reasoned written decision
                                    sufficient to explain the essential findings and conclusions on which the
                                    award is based.
                                  </p>

                                  <h3>Costs of Arbitration</h3>

                                  <p>
                                    Payment of all filing, administration, and arbitrator fees (collectively,
                                    the “Arbitration Fees”) will be governed by the AAA Rules, unless
                                    otherwise provided in this Arbitration Agreement. If the value of the
                                    relief sought is $75,000 or less, at your request, BancAnalytics will pay
                                    all Arbitration Fees. If the value of relief sought is more than $75,000
                                    and you can demonstrate to the arbitrator that you are economically unable
                                    to pay your portion of the Arbitration Fees or if the arbitrator otherwise
                                    determines for any reason that you should not be required to pay your
                                    portion of the Arbitration Fees, BancAnalytics will pay your portion of
                                    such fees. In addition, if you demonstrate to the arbitrator that the
                                    costs of arbitration will be prohibitive as compared to the costs of
                                    litigation, BancAnalytics will pay as much of the Arbitration Fees as the
                                    arbitrator deems necessary to prevent the arbitration from being
                                    cost-prohibitive. Any payment of attorneys’ fees will be governed by the
                                    AAA Rules.
                                  </p>

                                  <h3>Confidentiality</h3>

                                  <p>
                                    All aspects of the arbitration proceeding, and any ruling, decision, or
                                    award by the arbitrator, will be strictly confidential for the benefit of
                                    all parties.
                                  </p>

                                  <h3>Severability</h3>

                                  <p>
                                    If a court or the arbitrator decides that any term or provision of this
                                    Arbitration Agreement (other than the subsection above titled
                                    <strong
                                      >“Prohibition of Class and Representative Actions and Non-Individualized
                                      Relief”</strong
                                    >) is invalid or unenforceable, the parties agree to replace such term or
                                    provision with a term or provision that is valid and enforceable and that
                                    comes closest to expressing the intention of the invalid or unenforceable
                                    term or provision, and this Arbitration Agreement shall be enforceable as
                                    so modified. If a court or the arbitrator decides that any of the
                                    provisions of the subsection above titled
                                    <strong
                                      >“Prohibition of Class and Representative Actions and Non-Individualized
                                      Relief” </strong
                                    >” are invalid or unenforceable, then the entirety of this Arbitration
                                    Agreement shall be null and void. The remainder of the Terms of Service
                                    will continue to apply.
                                  </p>

                                  <h3>Future Changes to Arbitration Agreement</h3>

                                  <p>
                                    Notwithstanding any provision in these Terms of Service to the contrary,
                                    BancAnalytics agrees that if it makes any future change to this
                                    Arbitration Agreement (other than a change to the Notice Address) while
                                    you are a user of the Services, you may reject any such change by sending
                                    written notice within thirty (30) calendar days of the change to the
                                    Notice Address provided above. By rejecting any future change, you are
                                    agreeing that you will arbitrate any dispute between us in accordance with
                                    the language of this Arbitration Agreement as of the date you first
                                    accepted these Terms of Service (or accepted any subsequent changes to
                                    these Terms of Service).
                                  </p>

                                  <h3>Termination</h3>

                                  <p>
                                    You agree that BancAnalytics, in its sole discretion, may suspend or
                                    terminate your account (or any part thereof) or use of the Services and
                                    remove and discard any content within the Services, for any reason,
                                    including, without limitation, for lack of use or if BancAnalytics
                                    believes that you have violated or acted inconsistently with the letter or
                                    spirit of these Terms of Service. Any suspected fraudulent, abusive, or
                                    illegal activity that may be grounds for termination of your use of
                                    Services may be referred to appropriate law enforcement authorities.
                                    BancAnalytics may also in its sole discretion and at any time discontinue
                                    providing the Services, or any part thereof, with or without notice. You
                                    agree that any termination of your access to the Services under any
                                    provision of these Terms of Service may be done without prior notice and
                                    acknowledge and agree that BancAnalytics may immediately deactivate or
                                    delete your account and all related information and files in your account
                                    and/or bar any further access to such files or the Services. Further, you
                                    agree that BancAnalytics will not be liable to you or any third party for
                                    any termination of your access to the Services.
                                  </p>

                                  <h3>User Disputes</h3>

                                  <p>
                                    You agree that you are solely responsible for your interactions with any
                                    other user in connection with the Services and BancAnalytics will have no
                                    liability or responsibility with respect thereto. BancAnalytics reserves
                                    the right, but has no obligation, to become involved in any way with
                                    disputes between you and any other user of the Services.
                                  </p>

                                  <h3>General</h3>

                                  <p>
                                    These Terms of Service constitute the entire agreement between you and
                                    BancAnalytics, and govern your use of the Services, superseding any prior
                                    agreements between you and BancAnalytics with respect to the Services. You
                                    also may be subject to additional terms and conditions that may apply when
                                    you use affiliate or third-party services, third-party content or
                                    third-party software. These Terms of Service will be governed by the laws
                                    of the State of Missouri. With respect to any disputes or claims not
                                    subject to arbitration, as set forth above, you and BancAnalytics agree to
                                    submit to the personal and exclusive jurisdiction of the Missouri state
                                    courts and federal courts located within St. Louis, MO. The failure of
                                    BancAnalytics to exercise or enforce any right or provision of these Terms
                                    of Service will not constitute a waiver of such right or provision. If any
                                    provision of these Terms of Service is found by a court of competent
                                    jurisdiction to be invalid, the parties nevertheless agree that the court
                                    should endeavor to give effect to the parties’ intentions as reflected in
                                    the provision, and the other provisions of these Terms of Service remain
                                    in full force and effect. You agree that regardless of any statute or law
                                    to the contrary, any claim or cause of action arising out of or related to
                                    use of the Services or these Terms of Service must be filed within one (1)
                                    year after such claim or cause of action arose or be forever barred. A
                                    printed version of this agreement and of any notice given in electronic
                                    form will be admissible in judicial or administrative proceedings based
                                    upon or relating to this agreement to the same extent and subject to the
                                    same conditions as other business documents and records originally
                                    generated and maintained in printed form. You may not assign these Terms
                                    of Service without the prior written consent of BancAnalytics, but we may
                                    assign or transfer these Terms of Service, in whole or in part, without
                                    restriction. The section titles in these Terms of Service are for
                                    convenience only and have no legal or contractual effect. Notices to you
                                    may be made via either email or regular mail. The Services may also
                                    provide notices to you of changes to these Terms of Service or other
                                    matters by displaying notices or links to notices generally on the
                                    Services.
                                  </p>

                                  <h3>Your Privacy</h3>

                                  <p>
                                    At BancAnalytics, we respect the privacy of our users. We will not sell
                                    any of your account information including name, address, telephone number
                                    or email address. We will not transfer any of your account information to
                                    unaffiliated third parties unless it is necessary to provide the Services
                                    for which you paid.
                                  </p>

                                  <h3>Questions? Concerns? Suggestions?</h3>
                                  <p>
                                    Please contact us at
                                    <a href="support@intelli-rate.com">support@intelli-rate.com</a>to report
                                    any violations of these Terms of Service or to pose any questions
                                    regarding these Terms of Service or the Services.
                                  </p>
                            </div>
                        </div>
                        <form onsubmit="event.preventDefault()">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" wire:model="tandc" id="flexCheckDefault" required>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Check here to indicate that you have read and agree to our Terms & Conditions.</label>
                              </div>
                            {{-- <div class="col-md-2">
                            <input type="checkbox" class="form-control" name="terms" required>
                        </div>
                            <div class="col-md-10">
                                <p>Check here to indicate that you have read and agree to our Terms & Conditions.</p>
                            </div> --}}
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="mb-3 text-center">
                            <button type="submit"
                                class="btn submit_btn" wire:click="next">Next</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </section>
</div>

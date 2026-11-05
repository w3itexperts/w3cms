<form action="{{ @$config_master->id ? route('admin.solarmitra.config_master.update',@$config_master->id) : route('admin.solarmitra.config_master.store') }}" method="post" class="AjaxModalForm leads-modal">
	<div class="modal-header border-0">
		<h1 class="modal-title fs-5" id="exampleModalLabel7">{{@$config_master->id ? 'Edit' : 'Add'}} Configuration</h1>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body py-0 px-2 bg-body">
		<div class="row">
										
			<div class="col-md-2 border-end">
				<ul class="nav leads-nav nav-pills nav-pills-all flex-column align-items-center px-3 py-4" id="justify-tab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active d-flex gap-2 flex-column align-items-center" id="justify-identification-tab" data-bs-toggle="pill" data-bs-target="#identification" type="button" role="tab" aria-controls="justify-home" aria-selected="true">
						<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M30 33.3333C30 30.6811 28.9464 28.1375 27.0711 26.2622C25.1957 24.3868 22.6522 23.3333 20 23.3333C17.3478 23.3333 14.8043 24.3868 12.9289 26.2622C11.0536 28.1375 10 30.6811 10 33.3333" stroke="#919FBA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M20 23.3333C23.6819 23.3333 26.6667 20.3486 26.6667 16.6667C26.6667 12.9848 23.6819 10 20 10C16.3181 10 13.3334 12.9848 13.3334 16.6667C13.3334 20.3486 16.3181 23.3333 20 23.3333Z" stroke="#919FBA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M20 36.6666C29.2048 36.6666 36.6667 29.2047 36.6667 19.9999C36.6667 10.7952 29.2048 3.33325 20 3.33325C10.7953 3.33325 3.33337 10.7952 3.33337 19.9999C3.33337 29.2047 10.7953 36.6666 20 36.6666Z" fill="#919FBA" fill-opacity="0.1" stroke="#919FBA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
						Identification
						</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link d-flex gap-2 flex-column align-items-center" id="justify-data-tab" data-bs-toggle="pill" data-bs-target="#data" type="button" role="tab" aria-controls="justify-data" aria-selected="false" tabindex="-1">
						<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g clip-path="url(#clip0_1195_853)">
								<path d="M1.68702 2.94759e-05H12.1558C12.4058 -8.10569e-05 12.6526 0.0562811 12.8782 0.164981C13.1038 0.273681 13.3024 0.431962 13.4595 0.628211C13.5842 0.77732 13.6802 0.948584 13.7427 1.13322C13.8094 1.31537 13.8433 1.50809 13.8428 1.70228V12.2188C13.8419 12.4487 13.7954 12.6761 13.7061 12.8877C13.6168 13.0992 13.4864 13.2906 13.3228 13.4505C13.0082 13.7539 12.5909 13.9248 12.1558 13.9284H1.68702C1.47372 13.9251 1.26309 13.8799 1.0669 13.7954C0.860622 13.7147 0.672459 13.5932 0.513532 13.4379C0.354605 13.2826 0.228139 13.0968 0.141609 12.8913C0.0475807 12.6798 -0.000692422 12.4506 7.50371e-06 12.2188V1.70228C0.00259601 1.29118 0.150654 0.89454 0.417488 0.583869L0.488289 0.514892C0.633289 0.365647 0.803625 0.243833 0.991218 0.155227C1.20977 0.0547358 1.44685 0.00185371 1.68702 2.94759e-05ZM17.8442 16.0766H28.3203C28.5737 16.0751 28.8241 16.1315 29.0527 16.2416C29.2776 16.3513 29.476 16.5094 29.6338 16.7047C29.7555 16.8514 29.8513 17.018 29.917 17.1974C29.9838 17.3804 30.0177 17.574 30.0171 17.769V28.2855C30.0166 28.5134 29.97 28.7389 29.8804 28.9481C29.7909 29.1592 29.6606 29.3502 29.4971 29.5098C29.3408 29.6617 29.1567 29.7813 28.9551 29.8621C28.7569 29.9448 28.5446 29.9875 28.3301 29.9877H17.8442C17.6309 29.9862 17.4198 29.9444 17.2217 29.8645C17.0222 29.7846 16.8399 29.6667 16.6846 29.5172C16.5197 29.3576 16.3878 29.1668 16.2964 28.9555C16.2045 28.7443 16.1571 28.5161 16.1572 28.2855V17.7813C16.1566 17.5766 16.1938 17.3735 16.2671 17.1827C16.3375 16.9918 16.4408 16.8149 16.5723 16.6604L16.6406 16.5914C16.7862 16.4424 16.9575 16.3214 17.146 16.2342C17.3647 16.1313 17.6029 16.0775 17.8442 16.0766ZM28.3203 17.7739H17.8442V28.2978C18.7427 28.2978 28.3154 28.2978 28.3252 28.2978C28.3252 27.4109 28.3252 17.7788 28.3252 17.7739H28.3203ZM1.68702 16.0766H12.1558C12.4058 16.0765 12.6526 16.1328 12.8782 16.2415C13.1038 16.3502 13.3024 16.5085 13.4595 16.7047C13.5829 16.8502 13.6789 17.0171 13.7427 17.1974C13.8094 17.3804 13.8433 17.574 13.8428 17.769V28.2855C13.8422 28.5134 13.7957 28.7389 13.7061 28.9481C13.6185 29.1603 13.4879 29.3516 13.3228 29.5098C13.0082 29.8132 12.5909 29.9841 12.1558 29.9877H1.68702C1.47448 29.9864 1.26409 29.9446 1.0669 29.8645C0.866398 29.7852 0.683133 29.6672 0.527351 29.5172C0.362467 29.3582 0.231242 29.1671 0.141609 28.9555C0.0495257 28.7486 0.00129498 28.5246 7.50371e-06 28.2978V17.7813C0.000574121 17.5767 0.0377938 17.3739 0.109871 17.1827C0.181203 16.9917 0.285335 16.8149 0.417488 16.6604L0.488289 16.5914C0.632752 16.4422 0.803244 16.3211 0.991218 16.2342C1.20915 16.1316 1.44652 16.0778 1.68702 16.0766ZM12.1558 17.7739H1.68702V28.2978C2.58302 28.2978 12.1582 28.2978 12.1655 28.2978C12.1655 27.4109 12.1655 17.7788 12.1655 17.7739H12.1558ZM17.8442 2.94759e-05H28.3203C28.5737 -0.00147927 28.8241 0.0549504 29.0527 0.165081C29.2776 0.274755 29.476 0.432842 29.6338 0.628211C29.7567 0.778557 29.8526 0.94948 29.917 1.13322C29.9837 1.31537 30.0176 1.50809 30.0171 1.70228V12.2188C30.0168 12.4476 29.9703 12.6739 29.8804 12.8839C29.7904 13.0947 29.6602 13.2856 29.4971 13.4456C29.3349 13.5976 29.1451 13.7164 28.938 13.7954C28.7395 13.877 28.5273 13.9196 28.313 13.921H17.8442C17.6306 13.9201 17.4192 13.8774 17.2217 13.7954C17.0228 13.7154 16.8406 13.5984 16.6846 13.4505C16.5197 13.291 16.3878 13.1001 16.2964 12.8888C16.2043 12.6768 16.1569 12.4478 16.1572 12.2163V1.70228C16.1568 1.4984 16.1941 1.29623 16.2671 1.10612C16.337 0.915014 16.4404 0.738125 16.5723 0.583869L16.6406 0.514892C16.7867 0.365771 16.9578 0.243993 17.146 0.155227C17.3653 0.0543972 17.6033 0.0015073 17.8442 2.94759e-05ZM28.3203 1.69735H17.8442V12.2262C18.7427 12.2262 28.3154 12.2262 28.3252 12.2262C28.3252 11.3393 28.3252 1.70474 28.3252 1.70228L28.3203 1.69735ZM12.1631 1.69735H1.68702V12.2212C2.58302 12.2212 12.1582 12.2212 12.1655 12.2212C12.1655 11.3344 12.1655 1.69982 12.1655 1.69735H12.1631Z" fill="#919FBA"/>
							</g>
								<defs>
									<clipPath id="clip0_1195_853">
									<rect width="30" height="30" fill="white"/>
									</clipPath>
								</defs>
						</svg>
						Data & UI
						</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link d-flex gap-2 flex-column align-items-center" id="justify-options-tab" data-bs-toggle="pill" data-bs-target="#options" type="button" role="tab" aria-controls="justify-options" aria-selected="false" tabindex="-1">
						<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g clip-path="url(#clip0_1195_860)">
								<path d="M23.92 4.56665C23.8394 4.48608 23.7564 4.42798 23.671 4.39185C23.5909 4.35791 23.4974 4.34131 23.3902 4.34131C23.2825 4.34131 23.1871 4.3584 23.106 4.39282C23.022 4.42822 22.941 4.48535 22.8633 4.56421L22.8582 4.56934L21.3428 6.08008C21.1158 6.30591 20.765 6.33105 20.5103 6.15649C20.3321 6.04126 20.1422 5.93018 19.943 5.82251C19.7318 5.70825 19.5247 5.60571 19.3226 5.51294C19.1119 5.41675 18.8968 5.32617 18.6778 5.24121C18.4793 5.16406 18.2582 5.08545 18.0169 5.00586C17.7408 4.91479 17.5653 4.65796 17.5653 4.38184V2.05811C17.5653 1.94678 17.5477 1.84839 17.5128 1.7627C17.4779 1.67798 17.4247 1.59912 17.3512 1.52588C17.2796 1.45435 17.202 1.40137 17.117 1.36694C17.0316 1.33203 16.933 1.3147 16.8214 1.3147H13.9052C13.8019 1.3147 13.7103 1.3313 13.6303 1.3645C13.5453 1.39941 13.462 1.45654 13.3798 1.53613L13.3788 1.53687C13.3065 1.60913 13.2533 1.68604 13.2191 1.76782C13.184 1.85156 13.1664 1.94824 13.1664 2.05811V4.18555C13.1664 4.50903 12.9328 4.77783 12.6251 4.83276C12.3915 4.88843 12.1757 4.94605 11.9792 5.00635C11.7638 5.07227 11.5473 5.14722 11.3302 5.23193C11.3195 5.23608 11.3087 5.23999 11.298 5.24341C11.1083 5.31714 10.9084 5.40259 10.6984 5.49951C10.485 5.5979 10.2863 5.69775 10.1022 5.7981C9.84269 5.93945 9.52971 5.88696 9.32951 5.68994L9.32927 5.69019L7.65106 4.03613C7.64593 4.03101 7.64081 4.02588 7.63568 4.02075C7.56415 3.94507 7.48895 3.88989 7.4101 3.85547C7.33441 3.82251 7.24481 3.80566 7.14032 3.80566C7.03656 3.80566 6.94379 3.82324 6.86225 3.85815C6.77289 3.89624 6.68745 3.95581 6.60542 4.03613L6.60493 4.03662L4.56905 6.07715L4.56783 6.07861L4.56905 6.07983C4.48556 6.16333 4.42648 6.24634 4.39157 6.32886C4.35763 6.40894 4.34079 6.50244 4.34079 6.60938C4.34079 6.71729 4.35787 6.8125 4.3923 6.89404C4.4277 6.97778 4.48458 7.05884 4.56368 7.13647L4.56881 7.1416L6.07954 8.65723C6.30537 8.88428 6.33052 9.23511 6.15596 9.48975C6.04072 9.66821 5.92964 9.85791 5.82222 10.0571C5.70796 10.2686 5.60542 10.4751 5.51265 10.6777C5.41622 10.8882 5.32564 11.1035 5.24044 11.3225C5.16329 11.5208 5.08492 11.7419 5.00533 11.9832C4.91427 12.2595 4.65719 12.4348 4.38131 12.4348L2.05833 12.4351C1.94652 12.4351 1.84837 12.4524 1.76268 12.4871C1.67821 12.5217 1.60008 12.5745 1.5288 12.646L1.52611 12.6489C1.45458 12.7205 1.4016 12.7983 1.36693 12.8828C1.33202 12.9685 1.31493 13.0669 1.31493 13.1785V16.095C1.31493 16.198 1.33129 16.2898 1.36449 16.3696C1.39965 16.4546 1.45678 16.5378 1.53636 16.6204L1.5371 16.6209C1.60912 16.6931 1.68627 16.7466 1.76781 16.7805C1.85179 16.8157 1.94847 16.8333 2.05833 16.8333H4.18551C4.509 16.8333 4.77779 17.0669 4.83272 17.3748C4.88839 17.6082 4.946 17.8242 5.00631 18.0208C5.07247 18.2361 5.14718 18.4524 5.23189 18.6694C5.31148 18.8762 5.40181 19.0911 5.5024 19.3137C5.60518 19.5415 5.70576 19.749 5.80342 19.9368C5.9394 20.197 5.88301 20.5071 5.68477 20.7041L5.68526 20.7046L4.03097 22.354L4.02048 22.3643C3.94479 22.436 3.88962 22.5112 3.85544 22.5898C3.82223 22.6655 3.80563 22.7554 3.80563 22.8599C3.80563 22.9636 3.82321 23.0562 3.85788 23.1377C3.89596 23.2271 3.95553 23.3127 4.0361 23.3945L6.06465 25.4465C6.14399 25.52 6.22676 25.5737 6.31343 25.6077C6.40034 25.6421 6.49897 25.6589 6.60932 25.6589C6.72065 25.6589 6.82099 25.6416 6.90937 25.6067C6.99433 25.5732 7.07416 25.522 7.14814 25.4526L8.65179 23.925C8.87859 23.6946 9.23381 23.667 9.49113 23.8447C9.66911 23.9595 9.85832 24.0701 10.057 24.1772C10.2685 24.2917 10.475 24.3943 10.6776 24.4868C10.8881 24.5835 11.1034 24.6741 11.3224 24.759C11.5207 24.8359 11.7416 24.9146 11.9831 24.9941C12.2594 25.0852 12.4347 25.3423 12.4347 25.6182L12.435 27.9419C12.435 28.0532 12.4523 28.1516 12.4872 28.2373C12.5219 28.322 12.5746 28.3999 12.6461 28.4714L12.6474 28.4729L12.6486 28.4714C12.7919 28.6147 12.9677 28.6853 13.1781 28.6853H16.0941C16.1976 28.6853 16.2892 28.6689 16.3693 28.6357C16.4542 28.6006 16.5375 28.5435 16.6195 28.4639L16.6205 28.4631C16.6925 28.3909 16.746 28.314 16.7801 28.2324C16.8155 28.1484 16.8331 28.052 16.8331 27.9421V25.8145C16.8331 25.4912 17.0663 25.2222 17.3744 25.1675C17.6075 25.1118 17.8236 25.054 18.0204 24.9939C18.2354 24.9277 18.452 24.853 18.6688 24.7686C18.8758 24.6887 19.0909 24.5984 19.3141 24.4978C19.5411 24.395 19.7489 24.2947 19.9359 24.197C20.1966 24.061 20.5067 24.1177 20.7037 24.3157L20.7042 24.3152L22.3536 25.9692L22.3636 25.9797C22.4361 26.0559 22.5113 26.1108 22.5897 26.145C22.6663 26.178 22.7588 26.1948 22.8692 26.1948C22.9774 26.1948 23.0713 26.1772 23.1524 26.1423C23.2339 26.1069 23.3099 26.0525 23.379 25.9795C23.3865 25.9712 23.3946 25.9631 23.4034 25.9551L25.4466 23.9355C25.5196 23.8564 25.5735 23.7734 25.6072 23.6868C25.6416 23.5999 25.6587 23.501 25.6587 23.3906C25.6587 23.2793 25.6416 23.179 25.6067 23.0906C25.5728 23.0056 25.5218 22.926 25.4522 22.8521L23.9249 21.3481C23.6941 21.1213 23.6668 20.7664 23.8443 20.5088C23.9593 20.3308 24.0699 20.1416 24.177 19.9431C24.2916 19.7319 24.3941 19.5251 24.4866 19.3225C24.5831 19.1121 24.6736 18.8967 24.7588 18.6777C24.8355 18.4795 24.9143 18.2583 24.9939 18.0168C25.085 17.7405 25.3421 17.5652 25.6182 17.5652L27.9414 17.5649C28.053 17.5649 28.1516 17.5476 28.2371 17.5127C28.3215 17.478 28.3997 17.4253 28.4712 17.354L28.4736 17.3513C28.5452 17.2795 28.5986 17.2017 28.6328 17.1169C28.6677 17.0315 28.6848 16.9331 28.6848 16.8215V13.905C28.6848 13.802 28.6687 13.7102 28.6353 13.6301C28.6004 13.5454 28.5432 13.4619 28.4636 13.3794L28.4627 13.3787C28.3906 13.3064 28.3135 13.2532 28.2319 13.219C28.1485 13.1838 28.0518 13.1663 27.9417 13.1663H25.8145C25.4869 13.1663 25.2156 12.9272 25.1656 12.614C25.1141 12.4082 25.0559 12.1995 24.99 11.9875C24.9266 11.7842 24.8523 11.5691 24.7654 11.3418C24.761 11.3308 24.7574 11.3196 24.7539 11.3083C24.6714 11.0923 24.587 10.8892 24.5003 10.699C24.4063 10.4932 24.3067 10.2942 24.2012 10.1018C24.0601 9.84228 24.1126 9.5293 24.3094 9.3291V9.32886L25.9634 7.65063C25.9685 7.64551 25.9734 7.64038 25.9788 7.63525C26.0547 7.56372 26.1099 7.48853 26.1443 7.40991C26.1773 7.33423 26.1944 7.24463 26.1944 7.14014C26.1944 7.03638 26.1768 6.9436 26.1419 6.86206C26.1038 6.77271 26.0442 6.68726 25.9637 6.60522L25.9632 6.60474L23.9224 4.56885L23.92 4.56665ZM24.1792 3.18457C24.4239 3.28784 24.646 3.43896 24.8462 3.63916L24.8467 3.6394L26.8928 5.68091L26.898 5.68604C27.095 5.88623 27.2456 6.10669 27.3487 6.34839C27.4551 6.59766 27.5088 6.86157 27.5088 7.14014C27.5088 7.42285 27.4539 7.68701 27.3457 7.93384C27.2403 8.17603 27.0862 8.39136 26.887 8.58154L25.5767 9.91089C25.6153 9.99121 25.6538 10.0725 25.6912 10.1548C25.7962 10.3838 25.8924 10.6133 25.9798 10.843C25.9847 10.8533 25.9888 10.8638 25.9927 10.8745C26.0799 11.1033 26.1634 11.3464 26.243 11.6023C26.2686 11.6848 26.2935 11.7678 26.3174 11.8516H27.9414C28.2236 11.8516 28.4878 11.9033 28.7354 12.0068C28.9785 12.1086 29.1982 12.2588 29.3943 12.4563L29.4082 12.4702C29.6013 12.6699 29.7478 12.8901 29.8474 13.1318C29.9495 13.3777 30 13.6353 30 13.905V16.8213C30 17.1018 29.9504 17.3645 29.8503 17.6099C29.7502 17.8547 29.6011 18.0771 29.4016 18.2771L29.4006 18.2778L29.3992 18.2795L29.3982 18.2805C29.198 18.48 28.9758 18.6296 28.7302 18.7297C28.4846 18.8296 28.2219 18.8794 27.9417 18.8794H26.084C26.0515 18.9668 26.0179 19.0571 25.9815 19.1494C25.8885 19.3884 25.7879 19.6274 25.6787 19.8662C25.5657 20.113 25.4507 20.3462 25.3335 20.5637C25.295 20.635 25.2554 20.7061 25.2149 20.7771L26.3745 21.9187C26.3831 21.9268 26.3911 21.9348 26.3999 21.9436C26.5901 22.1448 26.7332 22.3682 26.8296 22.6123C26.9263 22.8574 26.9741 23.1172 26.9741 23.3901C26.9741 23.6621 26.9265 23.9197 26.8306 24.1638C26.7346 24.4072 26.593 24.6296 26.4048 24.8313C26.3982 24.8381 26.3914 24.8452 26.3843 24.8521L24.3262 26.8865C24.1331 27.0889 23.9156 27.2437 23.6714 27.3486C23.4249 27.4551 23.1583 27.509 22.8699 27.509C22.5877 27.509 22.3216 27.4539 22.0716 27.3462C21.824 27.239 21.6053 27.084 21.4146 26.8828L20.1099 25.5747C20.0228 25.6167 19.9373 25.6565 19.8543 25.6941C19.6322 25.7942 19.3946 25.8931 19.1424 25.9905C18.9054 26.0828 18.6581 26.168 18.4015 26.2466C18.316 26.2727 18.2318 26.2976 18.1488 26.3213V27.9419C18.1488 28.2239 18.0968 28.4883 17.9933 28.7356C17.8912 28.979 17.7416 29.1985 17.5436 29.3948L17.5296 29.4089C17.3299 29.6016 17.1095 29.7478 16.8683 29.8479C16.6222 29.9497 16.3646 30.0002 16.0948 30.0002H13.1784C12.6049 30.0002 12.1205 29.8025 11.7191 29.4011L11.7204 29.3999C11.5202 29.1995 11.37 28.9766 11.2699 28.7307C11.1698 28.4851 11.12 28.2227 11.12 27.9421V26.0845C11.0324 26.052 10.9423 26.0181 10.8498 25.9819C10.611 25.8889 10.372 25.7883 10.1332 25.679C9.88639 25.5662 9.65324 25.4509 9.43547 25.3335C9.36443 25.2952 9.29338 25.2556 9.22234 25.2151L8.08074 26.3748C8.07269 26.3833 8.06439 26.3916 8.05584 26.3999C7.85467 26.5906 7.63129 26.7336 7.38715 26.8298C7.14203 26.9265 6.88227 26.9746 6.60932 26.9746C6.33735 26.9746 6.07954 26.927 5.83565 26.8308C5.59224 26.7349 5.37007 26.5933 5.16817 26.4053L5.16842 26.4048C5.16134 26.3984 5.15425 26.3916 5.14766 26.3845L3.10154 24.3147C2.90476 24.1145 2.75413 23.8938 2.6511 23.6521C2.5449 23.4026 2.49095 23.1389 2.49095 22.8606C2.49095 22.5779 2.54588 22.3137 2.65379 22.0667C2.76048 21.8228 2.91526 21.6062 3.11692 21.4148L4.42526 20.1101C4.38327 20.0229 4.34323 19.9375 4.30563 19.8538C4.20529 19.6318 4.10666 19.3948 4.00949 19.1428C3.9172 18.9058 3.83176 18.6584 3.75314 18.4016C3.72702 18.3159 3.70212 18.2319 3.67844 18.1489H2.05833C1.77611 18.1489 1.51171 18.0969 1.26464 17.9934C1.02099 17.8916 0.801507 17.7417 0.605464 17.5439L0.591304 17.5293C0.398434 17.3298 0.252195 17.1094 0.152343 16.8679C0.0505367 16.6218 0 16.3643 0 16.095V13.1785C0 12.8979 0.0498043 12.6353 0.149901 12.3899C0.249998 12.1445 0.399167 11.9221 0.598872 11.7222L0.599116 11.7219L0.600581 11.7207L0.601802 11.7195C0.801995 11.5198 1.02416 11.3704 1.26977 11.2703C1.51512 11.1702 1.77782 11.1206 2.05833 11.1206H3.91598C3.94821 11.033 3.98239 10.9429 4.01852 10.8503C4.11129 10.6116 4.21212 10.3726 4.3215 10.1335C4.43429 9.88672 4.54928 9.65356 4.66695 9.43604C4.70602 9.36353 4.74654 9.29102 4.78805 9.21851L3.64523 8.07202L3.64475 8.07178C3.44284 7.87329 3.29001 7.6499 3.18577 7.40308C3.07908 7.15112 3.02634 6.88599 3.02634 6.60986C3.02634 6.33423 3.07883 6.07153 3.18479 5.8208C3.28977 5.57251 3.44113 5.34912 3.63962 5.15063L3.64084 5.15186L5.68086 3.10693L5.68599 3.10181C5.88618 2.90503 6.10664 2.75439 6.34834 2.65137C6.59785 2.54517 6.86152 2.49097 7.14008 2.49097C7.42255 2.49097 7.68671 2.5459 7.93377 2.65381C8.17596 2.75952 8.39129 2.91333 8.58147 3.11279L9.90983 4.42187C9.98966 4.38232 10.0693 4.34448 10.1486 4.30786C10.3529 4.21362 10.5785 4.11865 10.8254 4.02295C10.8358 4.01807 10.8466 4.01367 10.8573 4.00952C11.0944 3.91724 11.3419 3.83179 11.5988 3.75317C11.6842 3.72705 11.7685 3.70215 11.8515 3.67847V2.05811C11.8515 1.77612 11.9035 1.51172 12.007 1.26465C12.1088 1.021 12.2589 0.801514 12.4564 0.605225L12.4704 0.591309C12.6701 0.398437 12.8903 0.252441 13.1317 0.152588C13.3778 0.0505371 13.6354 0 13.9052 0H16.8212C17.1014 0 17.3644 0.0495605 17.6097 0.149658C17.8563 0.250244 18.0794 0.400391 18.2806 0.601318C18.4793 0.800537 18.6292 1.02319 18.7298 1.26953C18.8299 1.51489 18.8795 1.77759 18.8795 2.05786V3.91577C18.9671 3.94824 19.057 3.98242 19.1497 4.01831C19.3883 4.11108 19.627 4.21191 19.8661 4.32104C20.1131 4.43384 20.3463 4.54907 20.5636 4.66675C20.6366 4.70605 20.7091 4.74634 20.7816 4.78784L21.9278 3.64502L21.9283 3.64478C22.1268 3.44287 22.3504 3.29004 22.5967 3.18579C22.8489 3.0791 23.1136 3.02637 23.3897 3.02637C23.6658 3.02637 23.9285 3.07861 24.1792 3.18457ZM14.9999 8.62939C15.4347 8.62939 15.859 8.6709 16.2728 8.75342C16.6796 8.83472 17.0829 8.95947 17.482 9.12793L17.4864 9.12988L17.4874 9.12793C17.8685 9.29248 18.2298 9.48901 18.5716 9.71802C18.9102 9.94482 19.224 10.2009 19.5116 10.4858L19.514 10.4885C19.7992 10.7764 20.0553 11.0898 20.2821 11.4287C20.5111 11.7705 20.7074 12.1318 20.8719 12.5129C20.8795 12.531 20.8863 12.5491 20.8924 12.5674C21.0501 12.9504 21.1685 13.3369 21.2462 13.7273C21.3292 14.1414 21.3702 14.5654 21.3702 15C21.3702 15.4348 21.3292 15.8591 21.2462 16.2729C21.1651 16.6799 21.0401 17.0828 20.8719 17.4822L20.8699 17.4866L20.8719 17.4875C20.7074 17.8687 20.5108 18.2297 20.2821 18.5715C20.055 18.9104 19.7989 19.2239 19.514 19.5117L19.5116 19.5144C19.2235 19.7996 18.9102 20.0557 18.5711 20.2825C18.2298 20.5115 17.8683 20.7078 17.4874 20.8723C17.4693 20.8799 17.4513 20.887 17.4325 20.8928C17.0497 21.0508 16.663 21.1689 16.2728 21.2468C15.859 21.3296 15.4344 21.3709 14.9999 21.3709C14.5651 21.3709 14.141 21.3296 13.7272 21.2468C13.3202 21.1655 12.9171 21.0405 12.5177 20.8723L12.5133 20.8704L12.5126 20.8723C12.1315 20.7078 11.7699 20.5112 11.4284 20.2825C11.0895 20.0557 10.776 19.7996 10.4884 19.5144L10.486 19.5117C10.2008 19.2236 9.9445 18.9104 9.71794 18.5713C9.48918 18.2297 9.29265 17.8682 9.12834 17.4875C9.12053 17.4695 9.1137 17.4514 9.10759 17.4329C8.94963 17.0498 8.83147 16.6633 8.75359 16.2729C8.67107 15.8591 8.62957 15.4348 8.62957 15C8.62957 14.5652 8.67083 14.1411 8.75359 13.7273C8.83489 13.3203 8.95989 12.9172 9.12834 12.5181L9.13005 12.5137L9.12834 12.5129C9.29265 12.1318 9.48942 11.7705 9.71794 11.429C9.94474 11.0898 10.2008 10.7766 10.486 10.4885L10.4887 10.4861C10.7763 10.2012 11.0898 9.94507 11.4284 9.71826C11.7702 9.4895 12.1317 9.29272 12.5128 9.12817C12.5309 9.12036 12.549 9.11353 12.5675 9.10767C12.9506 8.94971 13.3368 8.83179 13.7272 8.75391C14.141 8.6709 14.5651 8.62939 14.9999 8.62939ZM16.016 10.0425C15.6879 9.97681 15.3495 9.94409 14.9999 9.94409C14.6505 9.94409 14.3121 9.97681 13.9838 10.0425C13.6649 10.1062 13.3605 10.1975 13.0705 10.3164C13.0578 10.3228 13.0448 10.3291 13.0314 10.3347C12.7145 10.4717 12.423 10.6289 12.1574 10.8066C11.8898 10.9856 11.6422 11.1882 11.4142 11.4138C11.1884 11.6421 10.9858 11.8901 10.8066 12.158C10.6288 12.4233 10.4716 12.7146 10.3349 13.0315L10.3332 13.0308C10.206 13.3328 10.1093 13.6506 10.0424 13.9841C9.97697 14.3123 9.94425 14.6506 9.94425 15C9.94425 15.3494 9.97697 15.6877 10.0424 16.0161C10.1061 16.335 10.1977 16.6394 10.3166 16.9294C10.3229 16.9424 10.3293 16.9551 10.3349 16.9685C10.4716 17.2854 10.6288 17.5764 10.8063 17.8418C10.9855 18.1096 11.1881 18.3577 11.4142 18.5859C11.6422 18.8118 11.89 19.0142 12.1576 19.1931C12.423 19.3708 12.7143 19.5281 13.0314 19.665L13.0307 19.6667C13.3329 19.7939 13.6505 19.8909 13.984 19.9573C14.3121 20.0229 14.6508 20.0554 15.0001 20.0554C15.3495 20.0554 15.6881 20.0227 16.0162 19.9573C16.3353 19.8936 16.6395 19.8022 16.9298 19.6833C16.9422 19.677 16.9554 19.6707 16.9689 19.665C17.2855 19.5281 17.5768 19.3708 17.8424 19.1931C18.11 19.0142 18.3578 18.8115 18.5858 18.5859C18.8119 18.3577 19.0145 18.1099 19.1937 17.842C19.3712 17.5767 19.5284 17.2854 19.6649 16.9685L19.6668 16.9692C19.794 16.6672 19.891 16.3494 19.9576 16.0161C20.023 15.6877 20.0557 15.3494 20.0557 15C20.0557 14.6506 20.0228 14.3123 19.9576 13.9841C19.8936 13.665 19.8026 13.3608 19.6834 13.0706C19.6768 13.0579 19.671 13.0449 19.6649 13.0315C19.5284 12.7146 19.3712 12.4233 19.1932 12.158C19.0145 11.8901 18.8116 11.6421 18.5858 11.4141C18.3578 11.1885 18.11 10.9858 17.8424 10.8069C17.5768 10.6292 17.2855 10.4719 16.9689 10.335L16.9693 10.3333C16.6673 10.2061 16.3497 10.1091 16.016 10.0425Z" fill="#919FBA"/>
							</g>
							<defs>
								<clipPath id="clip0_1195_860">
									<rect width="30" height="30" fill="white"/>
								</clipPath>
							</defs>
						</svg>
						Options
						</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link d-flex gap-2 flex-column align-items-center" id="justify-validation-tab" data-bs-toggle="pill" data-bs-target="#validation" type="button" role="tab" aria-controls="justify-validation" aria-selected="false" tabindex="-1">
						<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M14.9999 1C18.8658 1 22.3658 2.56702 24.8994 5.10042C27.433 7.63382 29 11.134 29 14.9998C29 18.866 27.433 22.366 24.8994 24.8994C22.3658 27.4327 18.8658 29 14.9999 29C11.134 29 7.634 27.433 5.10062 24.8996C2.56724 22.3662 1 18.866 1 14.9998C1 11.134 2.56701 7.63382 5.10062 5.10042C7.63422 2.56702 11.134 1 14.9999 1ZM8.87402 16.3077C8.57484 16.037 8.5516 15.5749 8.82253 15.2757C9.09323 14.9765 9.55533 14.9533 9.85452 15.224L12.9172 18.0012L20.1047 10.4735C20.3834 10.1804 20.8471 10.169 21.1399 10.4475C21.4327 10.7262 21.4443 11.1896 21.1656 11.4825L13.4853 19.5265L13.4844 19.5256C13.2121 19.812 12.7593 19.8305 12.4647 19.5639L8.87402 16.3077ZM23.8615 6.13835C21.5936 3.87064 18.4604 2.46768 14.9999 2.46768C11.5391 2.46768 8.40599 3.87041 6.1383 6.13812C3.87039 8.40605 2.46789 11.539 2.46789 14.9998C2.46789 18.4606 3.87061 21.5937 6.1383 23.8617C8.40599 26.1294 11.5391 27.5321 14.9999 27.5321C18.4604 27.5321 21.5936 26.1294 23.8615 23.8617C26.1294 21.5937 27.5317 18.4608 27.5317 14.9998C27.5319 11.5392 26.1294 8.40605 23.8615 6.13835Z" fill="#919FBA"/>
						</svg>
						Validation
						</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link d-flex gap-2 flex-column align-items-center" id="justify-behavior-tab" data-bs-toggle="pill" data-bs-target="#behavior" type="button" role="tab" aria-controls="justify-behavior" aria-selected="false" tabindex="-1">
						<svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M17.5 8.75V17.5H11.6666" stroke="#919FBA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
							<path d="M17.5 32.0834C25.5541 32.0834 32.0833 25.5542 32.0833 17.5001C32.0833 9.44593 25.5541 2.91675 17.5 2.91675C9.44581 2.91675 2.91663 9.44593 2.91663 17.5001C2.91663 25.5542 9.44581 32.0834 17.5 32.0834Z" fill="#919FBA" fill-opacity="0.1" stroke="#919FBA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
						</svg>
						Behavior
						</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link d-flex gap-2 flex-column align-items-center" id="justify-ui_ux-tab" data-bs-toggle="pill" data-bs-target="#ui_ux" type="button" role="tab" aria-controls="justify-ui_ux" aria-selected="false" tabindex="-1">
						<svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M17.5 32.0834C25.5541 32.0834 32.0833 25.5542 32.0833 17.5001C32.0833 9.44593 25.5541 2.91675 17.5 2.91675C9.44581 2.91675 2.91663 9.44593 2.91663 17.5001C2.91663 25.5542 9.44581 32.0834 17.5 32.0834Z" fill="#919FBA" fill-opacity="0.1" stroke="#919FBA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M17.5 23.3333V17.5" stroke="#919FBA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M17.5 11.6667H17.5167" stroke="#919FBA" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
						UI Enhance
						</button>
					</li>
				</ul>
			</div>
			
			<div class="col-md-10">
				
				<div class="tab-content leads" id="justify-tabContent">
					
					<div class="tab-pane fade show active" id="identification" role="tabpanel" aria-labelledby="profile" tabindex="0">
						<div class="row p-4" >
								
								<h3>Identification & Grouping Section</h3>

								<div class="col-xl-12 border rounded p-3 mb-3">
									
									<div class="row mb-3">
										<label class="col-sm-2 col-form-label">Module Code</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Module Code',
													'options'=>config('solarmitra.business_config.modules'),
													'type'=>'select',
													'id'=>'module_code',
													'class'=>' selectpicker',
													'field_name'=>'module_code',
													'old_field_value'=>old('configuration.module_code',@$config_master->module_code),

													],'configuration') !!}
        									<p class="text-danger error-text configuration module_code_error"></p>
										</div>
									</div>
									<div class="row mb-3">
										<label for="ConfigKey" class="col-sm-2 col-form-label">Field Key</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Field Key',
													'type'=>'text',
													'id'=>'field_key',
													'class'=>'form-control form-control-sm',
													'field_name'=>'field_key',
													'old_field_value'=>old('configuration.field_key',@$config_master->field_key),
												],'configuration') !!}
        									<p class="text-danger error-text configuration field_key_error"></p>
										</div>
									</div>
									<div class="row mb-3">
										<label for="display_title" class="col-sm-2 col-form-label">Display Title</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Display Title',
													'type'=>'text',
													'id'=>'display_title',
													'class'=>'form-control form-control-sm',
													'field_name'=>'display_title',
													'old_field_value'=>old('configuration.display_title',@$config_master->display_title),
												],'configuration') !!}
        									<p class="text-danger error-text configuration display_title_error"></p>
										</div>
									</div>
									<div class="row mb-3">
										<label for="Description" class="col-sm-2 col-form-label">Description</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Description',
													'type'=>'textarea',
													'id'=>'description',
													'class'=>'form-control form-control-sm h-auto',
													'rows'=>3,
													'field_name'=>'description',
													'old_field_value'=>old('configuration.description',@$config_master->description),
												],'configuration') !!}
        									<p class="text-danger error-text configuration description_error"></p>
										</div>
									</div>
									<div class="row mb-3">
										<label class="col-sm-2 col-form-label">Industry Code</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Industry Code',
													'type'=>'text',
													'id'=>'industry_code',
													'class'=>'form-control form-control-sm',
													'field_name'=>'industry_code',
													'old_field_value'=>old('configuration.industry_code',@$config_master->industry_code),
												],'configuration') !!}
        									<p class="text-danger error-text configuration industry_code_error"></p>
										</div>
									</div>
									<div class="row">
										<label class="col-sm-2 col-form-label">Config Group</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Config Group',
													'type'=>'text',
													'id'=>'config_group',
													'class'=>'form-control form-control-sm',
													'field_name'=>'config_group',
													'old_field_value'=>old('configuration.config_group',@$config_master->config_group),
												],'configuration') !!}
        									<p class="text-danger error-text configuration config_group_error"></p>
										</div>
									</div>
								</div>
								
						</div>
					</div>
					
					<div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data" tabindex="0">
						<div class="row p-4" >
								
								<h3>Data & UI Type Control</h3>

								<div class="col-xl-12 border rounded p-3 mb-3">
									
									<div class="row mb-3">
										<label class="col-sm-2 col-form-label">Value Type</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Value Type',
													'type'=>'select',
													'options'=>config('solarmitra.business_config_value_types'),
													'id'=>'value_type',
													'class'=>' selectpicker',
													'field_name'=>'value_type',
													'old_field_value'=>old('configuration.value_type',@$config_master->value_type),
												],'configuration') !!}
        									<p class="text-danger error-text configuration value_type_error"></p>
										</div>
									</div>
									<div class="row mb-3">
										<label for="field_type" class="col-sm-2 col-form-label">Field Type</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Field Type',
													'type'=>'select',
													'options'=>config('constants.custom_field_input_types'),
													'id'=>'field_type',
													'class'=>' selectpicker',
													'field_name'=>'field_type',
													'old_field_value'=>old('configuration.field_type',@$config_master->field_type),
												],'configuration') !!}
        									<p class="text-danger error-text configuration field_type_error"></p>
										</div>
									</div>
									<div class="row mb-3 align-items-center">
										<label for="is_multiple" class="col-sm-2 col-form-label">Is Multiple</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Is Multiple',
													'type'=>'switch',
													'id'=>'is_multiple',
											        'on' => __('Yes') ,
											        'off' => __('No') ,
													// 'class'=>' selectpicker',
													'old_field_value'=>old('configuration.is_multiple',@$config_master->is_multiple),
													'field_name'=>'is_multiple'
												],'configuration') !!}
        									<p class="text-danger error-text configuration is_multiple_error"></p>
										</div>
									</div>
									<div class="row">
										<label for="field_value" class="col-sm-2 col-form-label">Field Value</label>
										<div class="col-sm-10">
											{{-- <textarea type="text" class="" id="LeadIdentification11" rows="1"></textarea> --}}
											{!! ThemeOption::CreateField([
													'title'=>'Field Value',
													'type'=>'textarea',
													'id'=>'field_value',
													'class'=>'form-control form-control-sm h-auto',
													'rows'=>3,
													'old_field_value'=>old('configuration.field_value',@$config_master->field_value),
													'field_name'=>'field_value'
												],'configuration') !!}
        									<p class="text-danger error-text configuration field_value_error"></p>
										</div>
									</div>
								</div>
								
						</div>
					</div>
					
					<div class="tab-pane fade" id="options" role="tabpanel" aria-labelledby="options" tabindex="0">
						<div class="row p-4" >
								
								<h3>Options Section</h3>

								<div class="col-xl-12 border p-3 rounded mb-3">
									<div class="row align-items-center mb-2">
										<label class="col-sm-2 col-form-label" for="options_json">Options Json</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Options Json',
													'type'=>'textarea',
													'id'=>'options_json',
													'class'=>'form-control form-control-sm h-auto',
													'field_name'=>'options_json',
													'old_field_value'=>old('configuration.options_json',@$config_master->options_json),
													'rows'=>3,
												],'configuration') !!}
        									<p class="text-danger error-text configuration options_json_error"></p>
										</div>
									</div>
									<div class="row mb-3">
										<label class="col-sm-2 col-form-label" for="validation_rules_json">Validation Rules Json</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Validation Rules Json',
													'type'=>'textarea',
													'id'=>'validation_rules_json',
													'class'=>'form-control form-control-sm h-auto ',
													'old_field_value'=>old('configuration.validation_rules_json',@$config_master->validation_rules_json),
													'rows'=>3,
													'field_name'=>'validation_rules_json'
												],'configuration') !!}
        									<p class="text-danger error-text configuration validation_rules_json_error"></p>
										</div>
									</div>
								</div>
							
						</div>
					</div>
					
					<div class="tab-pane fade" id="validation" role="tabpanel" aria-labelledby="validation" tabindex="0">
						<div class="row p-4" >
							
								<h3>Validation Section</h3>

								<div class="col-xl-12 border rounded p-3 mb-3">
									<div class="row align-items-center mb-3">
										<label class="col-sm-2 col-form-label" for="is_required">Is Required</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Is Required',
													'type'=>'switch',
													'id'=>'is_required',
											        'on' => __('Yes') ,
											        'off' => __('No') ,
													// 'class'=>' selectpicker',
													'old_field_value'=>old('configuration.is_required',@$config_master->is_required),
													'field_name'=>'is_required'
												],'configuration') !!}
        									<p class="text-danger error-text configuration is_required_error"></p>
										</div>
									</div>
									<div class="row mb-3">
										<label for="min_value" class="col-sm-2 col-form-label">Min Value</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Min Value',
													'type'=>'text',
													'id'=>'min_value',
													'class'=>'form-control form-control-sm',
													'old_field_value'=>old('configuration.min_value',@$config_master->min_value),
													'field_name'=>'min_value'
												],'configuration') !!}
        									<p class="text-danger error-text configuration min_value_error"></p>
										</div>
									</div>
									<div class="row mb-3">
										<label for="max_value" class="col-sm-2 col-form-label">Max Value</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Max Value',
													'type'=>'text',
													'id'=>'max_value',
													'class'=>'form-control form-control-sm',
													'old_field_value'=>old('configuration.max_value',@$config_master->max_value),
													'field_name'=>'max_value'
												],'configuration') !!}
        									<p class="text-danger error-text configuration max_value_error"></p>
										</div>
									</div>
									<div class="row mb-3">
										<label for="step_value" class="col-sm-2 col-form-label">Step Value</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Step Value',
													'type'=>'text',
													'id'=>'step_value',
													'class'=>'form-control form-control-sm',
													'old_field_value'=>old('configuration.step_value',@$config_master->step_value),
													'field_name'=>'step_value'
												],'configuration') !!}
        									<p class="text-danger error-text configuration step_value_error"></p>
										</div>
									</div>
									<div class="row">
										<label for="regex_pattern" class="col-sm-2 col-form-label">Regex Pattern</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Regex Pattern',
													'type'=>'text',
													'id'=>'regex_pattern',
													'class'=>'form-control form-control-sm',
													'old_field_value'=>old('configuration.regex_pattern',@$config_master->regex_pattern),
													'field_name'=>'regex_pattern'
												],'configuration') !!}
        									<p class="text-danger error-text configuration regex_pattern_error"></p>
										</div>
									</div>
								</div>
						</div>
					</div>

					<div class="tab-pane fade" id="behavior" role="tabpanel" aria-labelledby="behavior" tabindex="0">
						<div class="row p-4" >
							
								<h3>Behavior Control Section</h3>

								<div class="col-xl-12 border rounded p-3 mb-3">

									<div class="row align-items-center mb-3">
										<label class="col-sm-2 col-form-label" for="is_readonly">Is Readonly</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Is Readonly',
													'type'=>'switch',
													'id'=>'is_readonly',
											        'on' => __('Yes') ,
											        'off' => __('No') ,
													// 'class'=>' selectpicker',
													'old_field_value'=>old('configuration.is_readonly',@$config_master->is_readonly),
													'field_name'=>'is_readonly'
												],'configuration') !!}
        									<p class="text-danger error-text configuration is_readonly_error"></p>
										</div>
									</div>
									<div class="row align-items-center mb-3">
										<label class="col-sm-2 col-form-label" for="is_hidden">Is Hidden</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Is Readonly',
													'type'=>'switch',
													'id'=>'is_hidden',
											        'on' => __('Yes') ,
											        'off' => __('No') ,
													// 'class'=>' selectpicker',
													'old_field_value'=>old('configuration.is_hidden',@$config_master->is_hidden),
													'field_name'=>'is_hidden'
												],'configuration') !!}
        									<p class="text-danger error-text configuration is_hidden_error"></p>
										</div>
									</div>
									<div class="row mb-3">
										<label class="col-sm-2 col-form-label">Depends On Key</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Depends On Key',
													'type'=>'text',
													'id'=>'depends_on_key',
													'class'=>'form-control form-control-sm',
													'old_field_value'=>old('configuration.depends_on_key',@$config_master->depends_on_key),
													'field_name'=>'depends_on_key'
												],'configuration') !!}
        									<p class="text-danger error-text configuration depends_on_key_error"></p>
										</div>
									</div>
									<div class="row mb-3">
										<label class="col-sm-2 col-form-label">Depends On Value</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Depends On Value',
													'type'=>'text',
													'id'=>'depends_on_value',
													'class'=>'form-control form-control-sm',
													'old_field_value'=>old('configuration.depends_on_value',@$config_master->depends_on_value),
													'field_name'=>'depends_on_value'
												],'configuration') !!}
        									<p class="text-danger error-text configuration depends_on_value_error"></p>
										</div>
									</div>
								</div>

						</div>
					</div>

					<div class="tab-pane fade" id="ui_ux" role="tabpanel" aria-labelledby="ui_ux" tabindex="0">
						<div class="row p-4" >
							
								<h3>UI / UX Enhancements</h3>

								<div class="col-xl-12 border rounded p-3 mb-3">
									<div class="row mb-3">
										<label class="col-sm-2 col-form-label" for="display_order">Display Order</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Display Order',
													'type'=>'text',
													'id'=>'display_order',
													'class'=>'form-control form-control-sm',
													'old_field_value'=>old('configuration.display_order',@$config_master->display_order),
													'field_name'=>'display_order'
												],'configuration') !!}
        									<p class="text-danger error-text configuration display_order_error"></p>
										</div>
									</div>
									<div class="row mb-3">
										<label class="col-sm-2 col-form-label" for="help_text">Help Text</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Help Text',
													'type'=>'text',
													'id'=>'help_text',
													'class'=>'form-control form-control-sm',
													'old_field_value'=>old('configuration.help_text',@$config_master->help_text),
													'field_name'=>'help_text'
												],'configuration') !!}
        									<p class="text-danger error-text configuration help_text_error"></p>
										</div>
									</div>
									<div class="row align-items-center">
										<label class="col-sm-2 col-form-label" for="is_active">Is Active</label>
										<div class="col-sm-10">
											{!! ThemeOption::CreateField([
													'title'=>'Is Active',
													'type'=>'switch',
													'default' => true,
													'id'=>'is_active',
											        'on' => __('Yes') ,
											        'off' => __('No') ,
													'old_field_value'=>old('configuration.is_active',@$config_master->is_active),
													'field_name'=>'is_active'
												],'configuration') !!}
        									<p class="text-danger error-text configuration is_active_error"></p>
										</div>
									</div>
								</div>

						</div>
					</div>
					
				</div>

			</div>
			
		</div>
	</div>
	<div class="modal-footer bg-body rounded-bottom">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">
			<i class="icon icon-save"></i>
			Save
		</button>
	</div>
</form>
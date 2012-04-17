<div  id="hcard-$Name" class="vcard">
    <% if ProfilePicture %>
        <img src="<% control ProfilePicture %><% control SetRatioSize(100,100) %>$Url<% end_control %><% end_control %>" alt="$Name" class="photo"/>
    <% end_if %>
    <!--    <span class="fn n">
            <span class="given-name"></span>
            <span class="additional-name"></span>
            <span class="family-name"></span>
        </span>-->
    <div class="org organization-name">$Name</div>
    <a class="email" href="mailto:$Email">$Email</a>
    <div class="adr">
        <div class="street-address">
		$Address
		<% if AddressAddition %>
        		$AddressAddition<br />
      		<% end_if %>
	</div>
        <div><span class="postal-code">$PostCode</span>
            <span class="locality">$City</span></div>
        <span class="region">$State</span>
        <span class="country-name">$getCountryName</span>
    </div>
    <div class="tel"><% _t('Profileable.Phone','Phone') %>: <span class="value">$Phone</span></div>
    <div class="tel"><span class="type"><% _t('Profileable.Fax','Fax') %></span>: <span class="value">$Fax</span></div>
    <a class="url fn org" href="http://$Www">$Www</a> 
</div>

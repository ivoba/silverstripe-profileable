<div  id="hcard-$ProfileName" class="vcard">
    <% if ProfilePicture %>
        <img src="<% control ProfilePicture %><% control SetRatioSize(100,100) %>$Url<% end_control %><% end_control %>" alt="$Name" class="photo"/>
    <% end_if %>
    <span class="fn">$GetFullName</span>
    <% if FirstName %>
    <span class="n">
            <span class="honorific-prefix">$AcademicTitle</span>
            <span class="given-name">$FirstName</span>
            <span class="family-name">$Surname</span>
    </span>
    <% else %>
    <span class="nickname">$ProfileName</span>
    <% end_if %>
    <div class="org organization-name">$Company</div>
    <a class="email" href="mailto:$Email">$Email</a>
    <div class="adr">
        <div class="street-address">$Address</div>
        <% if AddressAddition %><div class="extended-address">$AddressAddition</div><% end_if %>
        <div><span class="postal-code">$Postcode</span>
            <span class="locality">$City</span></div>
        <span class="region">$State</span>
        <% if Country %>
        <span class="country-name">$getCountryName</span>
        <% end_if %>
    </div>
    <% if Phone %><div class="tel"><% _t('Profileable.PHONE','Phone') %>: <span class="value">$Phone</span></div><% end_if %>
    <% if Fax %><div class="tel"><span class="type"><% _t('Profileable.FAX','Fax') %></span>: <span class="value">$Fax</span></div><% end_if %>
    <a class="url fn org" href="http://$Www">$Www</a> 
</div>

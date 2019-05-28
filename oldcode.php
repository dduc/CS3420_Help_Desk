
function dropdown()
{

	var x = document.getElementById("mynavbar");

	if (x.className === "navbar")
	{
		x.className += "responsive";
	}

	else
	{
		x.className = "navbar";
	}

}

<!-- <a  href ="javascript:void(0);" class = "icon" onclick = "dropdown()">&#9776;</a> -->


<form class = "form-inline" name= "client" action="client.php"  method="post">
<table>

<tr>
<td><label> First Name*: </label></td>
<td> <input type="text" name="fname" pattern="[A-Za-z0-9]{1,15}" required></td>

<td><label> Last Name*:</label></td>  
<td><input type="text" name="lname" pattern="[A-Za-z0-9]{1,15}" required></td>
</tr>


<tr>
<td><label> Address*: </label></td>
<td> <input type="text" name="address" pattern="[A-Za-z0-9'\.\-\s\,{1,30}" required></td> 

<td><label>State*: </label></td> 


<td> <select name = "state" required> 
<option value=""> </option> 
<option value="AL">AL</option>
<option value="AK">AK</option>
<option value="AZ">AZ</option>
<option value="AR">AR</option>
<option value="CA">CA</option>
<option value="CO">CO</option>
<option value="CT">CT</option>
<option value="DE">DE</option>
<option value="FL">FL</option>
<option value="GA">GA</option>
<option value="HI">HI</option>
<option value="ID">ID</option>
<option value="IL">IL</option>
<option value="IN">IN</option>
<option value="IA">IA</option>
<option value="KS">KS</option>
<option value="KY">KY</option>
<option value="LA">LA</option>
<option value="ME">ME</option>
<option value="MD">MD</option>
<option value="MA">MA</option>
<option value="MI">MI</option>
<option value="MN">MN</option>
<option value="MS">MS</option>
<option value="MO">MO</option>
<option value="MT">MT</option>
<option value="NE">NE</option>
<option value="NV">NV</option>
<option value="NH">NH</option>
<option value="NJ">NJ</option>
<option value="NM">NM</option>
<option value="NY">NY</option>
<option value="NC">NC</option>
<option value="ND">ND</option>
<option value="OH">OH</option>
<option value="OK">OK</option>
<option value="OR">OR</option>
<option value="PA">PA</option>
<option value="RI">RI</option>
<option value="SC">SC</option>
<option value="SD">SD</option>
<option value="TN">TN</option>
<option value="TX">TX</option>
<option value="UT">UT</option>
<option value="VT">VT</option>
<option value="VA">VA</option>
<option value="WA">WA</option>
<option value="WV">WV</option>
<option value="WI">WI</option>
<option value="WY">WY</option>

</select></td>
</tr>

<tr>
<td><label> City*: </label></td>
<td><input type="text" name="city" pattern = "[A-Za-z0-9required]{1,20}" required></td> 

<td><label>Zip*: </label></td>
<td><input type="text" name="zip" maxlength = 5 pattern = "[0-9]{5}" required></td>
</tr>

<tr>
<td><label>Phone* (xxx-xxx-xxxx): </label></td>
				    <td><input type="tel" name="phone" maxlength = 12 pattern = "\d{3}-\d{3}-\d{4}$" required></td> 
								<td><label>Business Name: </label></td>
								<td><input type="text" name="business_name"></td>
								</tr>

								<tr>
								<td><label>Fax (x-xxx-xxxxxxx): </label></td>
												  <td><input type="text" name="fax" maxlength = 13 pattern = "\d{1}-\d{3}-\d{7}"></td> 

															      <td><label>Email*: </label></td>
															      <td><input type="email" name="email" pattern = "[a-zA-Z0-9!#$%&amp;'*+\/=?^_`{|}~.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*" required></td>
															      </tr>

															      </table>

															      <br><br>
															      Problem Category*: 
															      <select name = "category" required> 
															      <option value=""> </option> 
															      <option value="Hardware">Hardware</option>
															      <option value="Software">Software</option>
															      <option value="Security">Security</option>
															      <option value="Network">Network</option>
															      </select>	

															      <br><br> 

															      Problem Description*:
															      <br> 
															      <textarea name="problem" maxlength = 150 id = problem_id rows = 3 cols = 30 style = "resize: none;" pattern = "[A-Za-z0-9!#$%&amp;'*+\/=?^_`{|}~.-]{1,150}" required></textarea><br><br>


															      <input type="submit" name="dbinsert" value = "Submit" style = "width: 200px; height: 60px; background-color: lime; text-color: black; font-family: Impact,Charcoal,sans-serif; font-size: 200%;"> 

															      <div>

															      <br>
															      <h2 style = 'font-style: normal; font-family: "Times New Roman", Times, serif;'> * means this field is required. </h2> 

															      </div>

															      </div>



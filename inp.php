<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
<style>
body {
  font-family: Avenir Next, Avenir, SegoeUI, sans-serif;
}


form {
  margin: 2em 0;
}
/**
* Make the field a flex-container, reverse the order so label is on top.
*/
 
.field {
  display: flex;
  flex-flow: column-reverse;
  margin-bottom: 1em;
}
/**
* Add a transition to the label and input.
* I'm not even sure that touch-action: manipulation works on
* inputs, but hey, it's new and cool and could remove the 
* pesky delay.
*/
label, input {
  transition: all 0.2s;
  touch-action: manipulation;
}

input {
  font-size: 1.5em;
  border: 0;
  border-bottom: 1px solid #ccc;
  font-family: inherit;
  -webkit-appearance: none;
  border-radius: 0;
  padding: 0;
  cursor: text;
}

input:focus {
  outline: 0;
  border-bottom: 1px solid #666;
}

label {
  text-transform: uppercase;
  letter-spacing: 0.05em;
}
/**
* Translate down and scale the label up to cover the placeholder,
* when following an input (with placeholder-shown support).
* Also make sure the label is only on one row, at max 2/3rds of the
* field—to make sure it scales properly and doesn't wrap.
*/
input:placeholder-shown + label {
  cursor: text;
  max-width: 66.66%;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  transform-origin: left bottom;
  transform: translate(0, 2.125rem) scale(1.5);
}
/**
* By default, the placeholder should be transparent. Also, it should 
* inherit the transition.
*/
::-webkit-input-placeholder {
  opacity: 0;
  transition: inherit;
}
/**
* Show the placeholder when the input is focused.
*/
input:focus::-webkit-input-placeholder {
  opacity: 1;
}
/**
* When the element is focused, remove the label transform.
* Also, do this when the placeholder is _not_ shown, i.e. when 
* there's something in the input at all.
*/
input:not(:placeholder-shown) + label,
input:focus + label {
  transform: translate(0, 0) scale(1);
  cursor: pointer;
}




Resources
	
	</style>

</head>

<body>
<h1>Floating labels demo</h1>
      <input type="text" name="fullname" id="fullname" placeholder="Jane Appleseed">
    <label for="fullname">Name</label>
   
  <div class="field">
    <input type="email" name="email" id="email" placeholder="jane.appleseed@example.com">
    <label for="email">Email</label>
  </div>
  </form>
  
  <p>Will probably work crap in lots of browsers. Works OK in recent Chrome, WebKit/Safari. See the <a href="http://thatemil.com/blog/2016/01/23/floating-label-no-js-pure-css/">accompanying blog post</a></p>
  
</body>
</html>
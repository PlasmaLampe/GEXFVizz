/**
 * source of this file:    http://reddaly.com/js/
 */
//mutator methods are suffixed with _
var Vector = function(x,y,z) { this.x = x || 0; this.y = y || 0; this.z = z || 0; }
Vector.prototype.copy    = function() { return new Vector(this.x, this.y, this.z) }
Vector.prototype.add     = function(v) { return this.copy().add_(v) }
Vector.prototype.add_    = function(v) { this.x += v.x; this.y += v.y; this.z += v.z; return this}
Vector.prototype.sub     = function(v) { return this.copy().sub_(v) }
Vector.prototype.sub_    = function(v) { this.x -= v.x; this.y -= v.y; this.z -= v.z; return this}
Vector.prototype.round_  = function() { this.x=Math.round(this.x); this.y = Math.round(this.y); this.z=Math.round(this.z); return this }
Vector.prototype.round   = function() { return this.copy().round_() }
Vector.prototype.scale   = function(s) { return this.copy().scale_(s) }
Vector.prototype.scale_  = function(s) { this.x *= s; this.y *= s; this.z *= s; return this }
Vector.prototype.dot     = function(v) { return this.x * v.x + this.y * v.y + this.z * v.z }
Vector.prototype.norm    = function(v) { return this.copy().scale(1/this.mag()) }
//project self in direction of v
Vector.prototype.proj    = function(v) { return v.scale(this.dot(v)/v.selfdot());}
Vector.prototype.selfdot = function() { return this.dot(this) }
Vector.prototype.sumOfSquaresTo = Vector.prototype.selfdot
Vector.prototype.mag     = function() { return Math.sqrt(this.selfdot()) }
var Vector2 = function(x,y) { Vector.call(this, x,y,0) }
var Vector3 = function(x,y,z) { Vector.call(this, x,y,z) }
Vector2.prototype = Vector.prototype;
Vector2.prototype.rotate_ = function(ang, rads) {
   if (!rads) ang = ang*Math.PI/180
   var cos=Math.cos(ang), sin=Math.sin(ang), x=this.x, y=this.y;
   this.x = cos*x - sin*y;
   this.y = cos*y + sin*x;
   return this;
}
Vector2.prototype.rotate = function(ang) { return this.copy().rotate_(ang) }
Vector3.prototype = Vector.prototype;
Vector.prototype.toString = function() { return "(" + this.x + "," + this.y + "," + this.z + ")"; }

//added
Vector.prototype.mul     = function(v) { return this.copy().mul_(v) }
Vector.prototype.mul_    = function(v) { this.x * v; this.y * v; this.z * v; return this}
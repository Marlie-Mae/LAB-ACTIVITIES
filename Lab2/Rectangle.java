public class Rectangle {
	private double length;
	private double width;
	private double area;
	
	public double calculteArea(double length, double width) {
		area = length * width;
		System.out.println("The area of the rectangle is " + area);
		
		return area;
		
	}
}

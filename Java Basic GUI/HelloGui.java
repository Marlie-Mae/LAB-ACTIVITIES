import javax.swing.*;
import java.awt.*;
public class HelloGui {

	public static void main(String[] args) {
		
		// Create a JFrame
		JFrame frame = new JFrame("Hello IT Elective 2");
		
		JLabel label = new JLabel("Hello, Marlie");
		
		// Add the label to the frame
		frame.getContentPane().add(label);
		
		// Set frame properties
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE); // Close operation
		frame.setSize(300, 200); //Size of the frame
		frame.setLocationRelativeTo(null); // Center the frame
		frame.setVisible(true);
		
		label.setHorizontalAlignment(SwingConstants.CENTER); // Horizontal alignment
		label.setVerticalAlignment(SwingConstants.CENTER); // Vertical alignment
		label.setFont(new Font("Serif", Font.BOLD, 48)); // Font type, style, and size
		label.setForeground(Color.RED); // Font color
		
	}

}
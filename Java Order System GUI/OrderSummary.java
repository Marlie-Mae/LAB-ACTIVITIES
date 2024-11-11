import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

public class OrderSummary extends JFrame {
    private JTextArea summaryTextArea;

    public OrderSummary(String orderSummary, double deliveryFee, double total) {
        setTitle("Order Summary"); //238, 228, 204
        setSize(550, 400); // Adjust the size as needed
        setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);

        // Title label
        JLabel titleLabel = new JLabel("ORDER SUMMARY");
        titleLabel.setHorizontalAlignment(SwingConstants.CENTER);
        titleLabel.setFont(new Font("Arial", Font.BOLD, 17));
        titleLabel.setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));

        // Summary text area
        summaryTextArea = new JTextArea(orderSummary);
        summaryTextArea.setFont(summaryTextArea.getFont().deriveFont(13f)); // Set the desired font size
        summaryTextArea.setBackground(Color.WHITE);
        summaryTextArea.setEditable(false);
        JScrollPane scrollPane = new JScrollPane(summaryTextArea);

        // Logo panel
        JPanel logoPanel = new JPanel();
        ImageIcon logoIcon = new ImageIcon("logo1.png"); // Replace "logo1.png" with your logo file path
        Image scaledImage = logoIcon.getImage().getScaledInstance(120, 120, Image.SCALE_SMOOTH);
        ImageIcon scaledLogoIcon = new ImageIcon(scaledImage);
        JLabel logoLabel = new JLabel(scaledLogoIcon);
        logoPanel.add(logoLabel);
        logoPanel.setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10)); // Adjust the padding as needed

        // Back button
        JButton backButton = new JButton("Back");
        backButton.setPreferredSize(new Dimension(100, 40)); // Set preferred size
        backButton.setFont(backButton.getFont().deriveFont(Font.BOLD, 15));
        backButton.setBackground(new Color(92, 64, 51));
        backButton.setForeground(Color.WHITE);
        backButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                // Close the OrderSummary window
                dispose();
                // Open the OrderSystemGUI window
                OrderSystemGUI orderSystemGUI = new OrderSystemGUI();
                orderSystemGUI.setVisible(true);
            }
        });

        // Delivery fee and total labels
        JLabel deliveryFeeLabel = new JLabel("Delivery Fee: PHP " + String.format("%.2f", deliveryFee));
        Font totalFont = new Font("Arial", Font.PLAIN, 15);
        JLabel totalLabel = new JLabel("Total: PHP " + String.format("%.2f", total));
        totalLabel.setFont(totalFont);

        // Arrange components using BorderLayout
        JPanel contentPanel = new JPanel(new BorderLayout());
        contentPanel.add(titleLabel, BorderLayout.NORTH);
        contentPanel.add(scrollPane, BorderLayout.CENTER);
        contentPanel.add(deliveryFeeLabel, BorderLayout.SOUTH);
        contentPanel.add(totalLabel, BorderLayout.SOUTH);

        getContentPane().add(contentPanel, BorderLayout.CENTER);
        getContentPane().add(logoPanel, BorderLayout.EAST); // Add the logo panel to the left side
        getContentPane().add(backButton, BorderLayout.SOUTH); // Add the back button to the bottom
    }
}

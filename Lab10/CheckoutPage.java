import javax.imageio.ImageIO;
import javax.swing.*;
import javax.swing.border.EmptyBorder;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.geom.Ellipse2D;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;

public class CheckoutPage extends JFrame {
    private JTextArea orderTextArea;
    private JLabel nameLabel;
    private JLabel totalLabel;

    public CheckoutPage(String name, Object[][] orderData, Object[][] selectedOrderData) {
        initComponents(name, orderData, selectedOrderData);
    }

    private void initComponents(String name, Object[][] orderData, Object[][] selectedOrderData) {
        setTitle("Checkout Page");
        setSize(490, 600);
        setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
        getContentPane().setBackground(Color.WHITE);

        JLabel titleLabel = new JLabel("ORDER SUMMARY");
        titleLabel.setHorizontalAlignment(SwingConstants.CENTER);
        titleLabel.setFont(new Font("Arial", Font.BOLD, 23));
        titleLabel.setBorder(new EmptyBorder(10, 10, 10, 0));
        titleLabel.setBackground(Color.WHITE); 
        titleLabel.setOpaque(true); 


        nameLabel = new JLabel("Customer's Name: " + name);

        orderTextArea = new JTextArea();
        orderTextArea.setEditable(false);
        orderTextArea.setFont(new Font("Arial", Font.PLAIN, 14));
        JScrollPane scrollPane = new JScrollPane(orderTextArea);
        orderTextArea.setBorder(new EmptyBorder(10, 10, 10, 0));
        scrollPane.setPreferredSize(new Dimension(400, 200)); 

        
        // Add logo
        try {
            BufferedImage logoImage = ImageIO.read(new File("logo1.png"));
            Image scaledLogoImage = logoImage.getScaledInstance(100, 100, Image.SCALE_SMOOTH);
            BufferedImage roundedLogoImage = new BufferedImage(100, 100, BufferedImage.TYPE_INT_ARGB);
            Graphics2D g2d = roundedLogoImage.createGraphics();
            g2d.setClip(new Ellipse2D.Float(0, 0, 100, 100));
            g2d.drawImage(scaledLogoImage, 0, 0, null);
            g2d.dispose();
            ImageIcon logoIcon = new ImageIcon(roundedLogoImage);
            JLabel logoLabel = new JLabel(logoIcon);

            GridBagConstraints constraints = new GridBagConstraints();
            constraints.gridx = 1; 
            constraints.gridy = 0;

            JPanel logoPanel = new JPanel(new GridBagLayout());
            logoPanel.setOpaque(false); 
            logoPanel.add(logoLabel, constraints);

            getContentPane().add(logoPanel, BorderLayout.NORTH);
        } catch (IOException ex) {
            ex.printStackTrace();
        }

        // Build order summary string
        StringBuilder orderSummary = new StringBuilder();
        orderSummary.append("Customer's Name: " + name);
        orderSummary.append("\n\n");
        double totalAmount = 0.00;
        orderSummary.append("Order Details:\n");
        for (Object[] order : orderData) {
            orderSummary.append(order[0]).append("\n");
            orderSummary.append("Quantity: ").append(order[1]).append(", Amount: ").append(order[2]).append("\n\n");
            String amountStr = order[2].toString().replaceAll("[^0-9.]", "");
            double amount = Double.parseDouble(amountStr);
            double quantity = Double.parseDouble(order[1].toString());
            totalAmount += quantity * amount;
        }
        double deliveryfee = 50.00;
        double total = totalAmount + deliveryfee;
        orderSummary.append("Subtotal: Php").append(totalAmount + "0").append("\n");
        orderSummary.append("\n");
        orderSummary.append("Delivery fee: Php50.00");
        orderSummary.append("\n\n\n");
        orderSummary.append("Total: Php" + total + "0");

        orderTextArea.setText(orderSummary.toString());

        JButton backButton = new JButton("Back");
        backButton.setPreferredSize(new Dimension(150, 40));
        backButton.setFont(backButton.getFont().deriveFont(Font.BOLD, 15));
        backButton.setBackground(new Color(92, 64, 51));
        backButton.setForeground(Color.WHITE);
        backButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                dispose();
                String remarks = "N/A";
				String contact = "N/A";
				String address = "N/A";
                OrderPage orderPage = new OrderPage(name, address, contact, remarks);
                orderPage.setVisible(true);
            }
        });

        JPanel contentPanel = new JPanel(new BorderLayout());
        contentPanel.add(titleLabel, BorderLayout.NORTH);
        contentPanel.add(nameLabel, BorderLayout.CENTER);
        contentPanel.add(scrollPane, BorderLayout.CENTER);
        contentPanel.add(backButton, BorderLayout.SOUTH);
        getContentPane().add(contentPanel);
    }

    public static void main(String[] args) {
        SwingUtilities.invokeLater(() -> {
            String name = "No name";
            Object[][] orderData = {
                    {"Iced Coffee, Cold, Medium", "2", "50.00"},
                    {"Latte, Hot, Medium", "1", "100.00"}
            };
            Object[][] selectedOrderData = {
                    {"Iced Coffee, Cold, Medium", "2", "50.00"}
            };

            CheckoutPage checkoutPage = new CheckoutPage(name, orderData, selectedOrderData);
            checkoutPage.setVisible(true);
        });
    }
}
